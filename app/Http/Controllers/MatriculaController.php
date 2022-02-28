<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Unidade;
use App\Models\Vendedor;
use App\Services\Services;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{

    /*
    Função Index de Matricula
    - Responsável por mostrar a tela de listagem de matricula 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Matricula::orderby('id', 'desc');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('ativacao', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de categoria de Curso passando parametros para view
        return view('painelAdmin.matricula.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Matricula
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $alunos = Aluno::where('status', '=', 1)->get();
        $unidades = Unidade::where('status', '=', 1)->get();
        $vendedores = Vendedor::where('status', '=', 1)->get();
        $cursos = Curso::where('status', '=', 1)->get();

        //Exibe a tela de cadastro de professor
        return view('painelAdmin.matricula.cadastro', [
            'alunos' => $alunos,
            'unidades' => $unidades,
            'vendedores' => $vendedores,
            'cursos' => $cursos,
        ]);
    }

    /*
    Função Inserir de Matricula
    - Responsável por inserir as informações de uma matricula
    - $request: Recebe valores da matricula
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo_pagamento' => 'required',
            'unidade' => 'required',
            'nivel' => 'required',
        ]);

        //Nova instância do Model Matricula
        $item = new Matricula();

        //Atribuição dos valores recebidos da váriavel $request
        //1 -> Código da Unidade
        //2 -> Caracter aleatório
        //3 -> Tipo do Curso -> I M A T
        //4 -> Ano
        // XXX1492FBDA3A22
        // 111122222222344

        $item->ativacao = str_pad($request->unidade, 4, "X", STR_PAD_RIGHT) . strtoupper(bin2hex(random_bytes(4))) . (new CursoController())->codigo_tipo($request->nivel) . date("y");
        $item->tipo_pagamento = $request->tipo_pagamento;
        if ($item->tipo_pagamento == 2) {
            $item->quant_parcelas = $request->quant_parcelas_venda;
            $item->mes_inicio_pagamento = $request->mes_inicio_pagamento;
        }
        $item->valor_venda = $request->valor_venda;
        $item->nivel_curso = $request->nivel;
        $item->status = 2;

        $item->aluno_id = $request->aluno;
        $item->unidade_id = $request->unidade;
        $item->curso_id = $request->curso;
        $item->vendedor_id = $request->vendedor;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota matriculaIndex, com mensagem de sucesso
            return redirect()->route('matriculaIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Inserir de Matricula
    - Responsável por inserirMatriculaVendedor as informações de uma matricula
    - $request: Recebe valores da matricula
    */
    public function inserirMatriculaVendedor(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo_pagamento' => 'required',
            'nivel' => 'required',
        ]);

        //Nova instância do Model Matricula
        $item = new Matricula();

        //Atribuição dos valores recebidos da váriavel $request
        //1 -> Código da Unidade
        //2 -> Caracter aleatório
        //3 -> Tipo do Curso -> I M A T
        //4 -> Ano
        // XXX1492FBDA3A22
        // 111122222222344

        $item->ativacao = str_pad($request->unidade, 4, "X", STR_PAD_RIGHT) . strtoupper(bin2hex(random_bytes(4))) . (new CursoController())->codigo_tipo($request->nivel) . date("y");
        $item->tipo_pagamento = $request->tipo_pagamento;
        if ($item->tipo_pagamento == 2) {
            $item->quant_parcelas = $request->quant_parcelas_venda;
            $item->mes_inicio_pagamento = $request->mes_inicio_pagamento;
        }
        $item->valor_venda = $request->valor_venda;
        $item->nivel_curso = $request->nivel;
        $item->status = 2;

        $item->aluno_id = $request->aluno;
        $item->unidade_id = $_SESSION['vendedor_cursos_start']->unidade_id;
        $item->curso_id = $request->curso;
        $item->vendedor_id = $_SESSION['vendedor_cursos_start']->id;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota verMatriculaVendedor, com mensagem de sucesso
            return redirect()->route('verMatriculaVendedor', [$item->id])->with('sucesso', 'matrícula gerada!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Inserir de Matricula
    - Responsável por inserirMatriculaVendedor as informações de uma matricula
    - $request: Recebe valores da matricula
    */
    public function inserirMatriculaUnidade(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo_pagamento' => 'required',
            'nivel' => 'required',
        ]);

        //Nova instância do Model Matricula
        $item = new Matricula();

        //Atribuição dos valores recebidos da váriavel $request
        //1 -> Código da Unidade
        //2 -> Caracter aleatório
        //3 -> Tipo do Curso -> I M A T
        //4 -> Ano
        // XXX1492FBDA3A22
        // 111122222222344

        $item->ativacao = str_pad($request->unidade, 4, "X", STR_PAD_RIGHT) . strtoupper(bin2hex(random_bytes(4))) . (new CursoController())->codigo_tipo($request->nivel) . date("y");
        $item->tipo_pagamento = $request->tipo_pagamento;
        if ($item->tipo_pagamento == 2) {
            $item->quant_parcelas = $request->quant_parcelas_venda;
            $item->mes_inicio_pagamento = $request->mes_inicio_pagamento;
        }
        $item->valor_venda = $request->valor_venda;
        $item->nivel_curso = $request->nivel;
        $item->status = 2;

        $item->aluno_id = $request->aluno;
        $item->unidade_id = $_SESSION['unidade_cursos_start']->id;
        $item->curso_id = $request->curso;
        $item->vendedor_id = $_SESSION['unidade_cursos_start']->vendedor_id;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota verMatriculaUnidade, com mensagem de sucesso
            return redirect()->route('verMatriculaUnidade', [$item->id])->with('sucesso', 'matrícula gerada!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Ver Matricula  de Vendedor
    - Responsável por mostrar a tela de ver Matrícula Vendedor
    - $item: Recebe o Id de matrícula que deverá ser editado
    */
    public function verMatriculaVendedor($id)
    {
        $item = Matricula::leftjoin('cursos', 'matriculas.curso_id', '=', 'cursos.id')
            ->leftJoin('alunos', 'matriculas.aluno_id', '=', 'alunos.id')
            ->where('matriculas.status', '<>', '0')
            ->selectRaw('matriculas.*,  date_format(matriculas.created_at, "%d/%m/%H às %H:%i") as data, cursos.nome as curso, alunos.nome as aluno')
            ->find($id);

        //Verifica se há alguma matrícula selecionada
        if (@$item) {


            if ($item->status == 0) {
                return redirect()->route('cadastroMatriculaVendedor')->with('atencao', 'Matrícula excluida!');
            }

            //Exibe a tela de edição de vendedoristradores passando parametros para view
            return view('painelVendedor.matricula.verMatriculaVendedor', ['item' => $item]);
        } else {
            //Redirecionamento para a rota vendedorIndex, com mensagem de erro
            return redirect()->route('cadastroMatriculaVendedor')->with('erro', 'Matrícula não encontrada!');
        }
    }

    /*
    Função Ver Matricula  de Vendedor
    - Responsável por mostrar a tela de ver Matrícula Vendedor
    - $item: Recebe o Id de matrícula que deverá ser editado
    */
    public function verMatriculaUnidade($id)
    {
        $item = Matricula::leftjoin('cursos', 'matriculas.curso_id', '=', 'cursos.id')
            ->leftJoin('alunos', 'matriculas.aluno_id', '=', 'alunos.id')
            ->where('matriculas.status', '<>', '0')
            ->selectRaw('matriculas.*,  date_format(matriculas.created_at, "%d/%m/%H às %H:%i") as data, cursos.nome as curso, alunos.nome as aluno')
            ->find($id);

        //Verifica se há alguma matrícula selecionada
        if (@$item) {


            if ($item->status == 0) {
                return redirect()->route('cadastroMatriculaUnidade')->with('atencao', 'Matrícula excluida!');
            }

            //Exibe a tela de edição de vendedoristradores passando parametros para view
            return view('painelUnidade.matricula.verMatriculaUnidade', ['item' => $item]);
        } else {
            //Redirecionamento para a rota vendedorIndex, com mensagem de erro
            return redirect()->route('cadastroMatriculaUnidade')->with('erro', 'Matrícula não encontrada!');
        }
    }

    /*
    Função Editar de Categoria de Curso
    - Responsável por mostrar a tela de edição de Categoria de Curso
    - $item: Recebe o Id do Categoria de Curso que deverá ser editado
    */
    public function editar(Matricula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma categoria de curso  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('matriculaIndex')->with('atencao', 'Categoria de Curso excluido!');
            }

            //Exibe a tela de edição de categoria de curso passando parametros para view
            return view('painelAdmin.matricula.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota matriculaIndex, com mensagem de erro
            return redirect()->route('matriculaIndex')->with('erro', 'Categoria de Curso não encontrado!');
        }
    }

    /*
    Função Salvar de Categoria de Curso
    - Responsável por editar as informações de uma categoria de curso já cadastrado
    - $request: Recebe valores de uma categoria de curso
    - $item: Recebe uma objeto de Categoria de Curso vázio para edição
    */
    public function salvar(Request $request, Matricula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoadmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Redirecionamento para a rota matriculaIndex, com mensagem de sucesso
            return redirect()->route('matriculaIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Categoria de Curso
    - Responsável por excluir as informações de uma Categoria de Curso
    - $request: Recebe o Id do uma Categoria de Curso a ser excluido
    */
    public function cancelar(Matricula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoMatricula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Categoria de Curso informado
        if ($item->save()) {

            //Redirecionamento para a rota matriculaIndex, com mensagem de sucesso
            return redirect()->route('matriculaIndex')->with('sucesso', 'Matricula excluido!');
        } else {
            //Redirecionamento para a rota matriculaIndex, com mensagem de erro
            return redirect()->route('matriculaIndex')->with('erro', 'Matricula não excluido!');
        }
    }

    /*
    Função tipoPagamento de Matricula
    - Responsável por exibir o status do Matricula
    - $status: Recebe o Id do status do Matricula
    */
    public function tipoPagamento($tipoPagamento)
    {
        //Verifica o status do Matricula
        switch ($tipoPagamento) {
            case 1:
                //Retorna o status Ativo
                return 'A Vista';
                break;

            case 2:
                //Retorna o status Inativo
                return 'A Prazo';
                break;

            case 0:
                //Retorna o status Excluido
                return 'Outros';
                break;
        }
    }

    /*
    Função status de Categoria de Curso
    - Responsável por exibir o status do Categoria de Curso
    - $status: Recebe o Id do status do Categoria de Curso
    */
    public function status($status)
    {
        //Verifica o status do Categoria de Curso
        switch ($status) {
            case 1:
                //Retorna o status Ativo
                return 'Ativo';
                break;

            case 2:
                //Retorna o status Inativo
                return 'Aguardando Ativação';
                break;

            case 0:
                //Retorna o status Excluido
                return 'Cancelado';
                break;
        }
    }
}
