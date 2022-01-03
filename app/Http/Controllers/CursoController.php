<?php

namespace App\Http\Controllers;

use App\Models\CategoriaCurso;
use App\Models\Curso;
use App\Models\Professor;
use App\Services\Services;
use Illuminate\Http\Request;

class CursoController extends Controller
{

    /*
    Função Index de Curso
    - Responsável por mostrar a tela de listagem de Curso 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Curso::join('professors', 'cursos.professor_id', '=', 'professors.id')
        ->join('categoria_cursos', 'cursos.categoria_id', '=', 'categoria_cursos.id')
        ->orderby('cursos.nome', 'asc')
        ->where('cursos.status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('cursos.nome', 'like', '%' . $request->busca . '%');
            $consulta->where('professors.nome', 'like', '%' . $request->busca . '%');
            $consulta->where('categoria_cursos.nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->selectRaw('cursos.*, categoria_cursos.nome as categoria, professors.nome as professor')
        ->paginate();

        //Exibe a tela de listagem de categoria de Curso passando parametros para view
        return view('painelAdmin.curso.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Curso
    - Responsável por mostrar a tela de cadastro de curso
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $categoria = CategoriaCurso::where('status', '=', '1')->get();
        $professor = Professor::where('status', '=', '1')->get();

        //Exibe a tela de cadastro de curso
        return view('painelAdmin.curso.cadastro', [
            'categoria' => $categoria,
            'professor' => $professor
        ]);
    }

    /*
    Função Inserir de Curso
    - Responsável por inserir as informações de um novo curso
    - $request: Recebe valores do novo curso
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:100',
            'categoria' => 'required',
            'professor' => 'required'
        ]);

        //Nova instância do Model Curso
        $item = new Curso();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->professor_id = $request->professor;
        $item->categoria_id = $request->categoria;
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->porcentagem_solicitacao_certificado = '100';

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota CursoIndex, com mensagem de sucesso
            return redirect()->route('cursoEditar', [$item])->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Categoria de Curso
    - Responsável por mostrar a tela de edição de Categoria de Curso
    - $item: Recebe o Id do Categoria de Curso que deverá ser editado
    */
    public function editar(Curso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma categoria de curso  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('cursoIndex')->with('atencao', 'Categoria de Curso excluido!');
            }

            //Exibe a tela de edição de categoria de curso passando parametros para view
            return view('painelAdmin.curso.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota CursoIndex, com mensagem de erro
            return redirect()->route('cursoIndex')->with('erro', 'Categoria de Curso não encontrado!');
        }
    }

    /*
    Função Salvar de Categoria de Curso
    - Responsável por editar as informações de uma categoria de curso já cadastrado
    - $request: Recebe valores de uma categoria de curso
    - $item: Recebe uma objeto de Categoria de Curso vázio para edição
    */
    public function salvar(Request $request, Curso $item)
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

            //Redirecionamento para a rota CursoIndex, com mensagem de sucesso
            return redirect()->route('cursoIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
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
    public function deletar(Curso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoCurso, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Categoria de Curso informado
        if ($item->save()) {

            //Redirecionamento para a rota CursoIndex, com mensagem de sucesso
            return redirect()->route('cursoIndex')->with('sucesso', 'Curso excluido!');
        } else {
            //Redirecionamento para a rota CursoIndex, com mensagem de erro
            return redirect()->route('cursoIndex')->with('erro', 'Curso não excluido!');
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
                return 'Inativo';
                break;

            case 0:
                //Retorna o status Excluido
                return 'Excluido';
                break;
        }
    }
}
