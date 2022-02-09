<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\AulaAluno;
use App\Models\Canvas;
use App\Models\CategoriaCurso;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Professor;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{

    public function verAulas($id_curso, $link = '')
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        $id_aluno = $_SESSION['aluno_cursos_start']->id;

        $matricula = Matricula::where('aluno_id', '=', $id_aluno)
            ->where('curso_id', '=', $id_curso)
            ->where('status', '=', 1)
            ->first();

        if ($matricula) {

            $curso = Curso::find($id_curso);

            $aulas = Aula::where('aulas.curso_id', '=', $id_curso)
                ->where('aulas.status', '=', '1')
                ->orderByRaw('-ordem desc')
                ->orderby('ordem', 'desc')
                ->get();

            $aulas_feitas = AulaAluno::where('aluno_id', '=', $id_aluno)
                ->where('curso_id', '=', $id_curso)
                ->whereNotNull('conclusao')
                ->get();

            $minutos_feitos = 0;
            $minutos_total = 0;
            $j = 0;
            $ids_feitos = data_get($aulas_feitas, '*.aula_id');
            $ultima_feita = null;
            $atual = 9999;
            $proxima_afazer = null;

            for ($i = 0; $i < count($aulas); $i++) {
                if (in_array($aulas[$i]->id, $ids_feitos)) {
                    $minutos_feitos += $aulas[$i]->duracao;
                    $aulas[$i]->registro = $aulas_feitas->firstWhere('aula_id', $aulas[$i]->id);
                } else {
                    if ($atual > $i) {
                        $atual = $i;
                        if (isset($aulas[$i + 1])) {
                            $proxima_afazer = $i + 1;
                        }
                    }
                }

                if (isset($aulas[$i - 1]) and in_array($aulas[$i - 1]->id, $ids_feitos)) {
                    $ultima_feita = $i - 1;
                }

                $minutos_total += $aulas[$i]->duracao;
            }

            if ($minutos_feitos > 0) {
                $porcentagem = ($minutos_feitos * 100) / $minutos_total;
            } else {
                $porcentagem = 0;
            }

            //Exibe a tela inícial do painel de alunoistradores passando parametros para view
            return view('painelAluno.aula.verAulasCurso', [
                'curso' => $curso,
                'aulas' => $aulas,
                'ids_feitos' => $ids_feitos,
                'minutos_feitos' => $minutos_feitos,
                'minutos_total' => $minutos_total,
                'porcentagem' => $porcentagem,
                'ultima_feita' => $ultima_feita,
                'atual' => $atual,
                'proxima_afazer' => $proxima_afazer
            ]);
        } else {
            return redirect()->route('alunoCursos')->with('atencao', 'Selecione um de seus cursos!');
        }
    }

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
            $consulta->orWhere('professors.nome', 'like', '%' . $request->busca . '%');
            $consulta->orWhere('categoria_cursos.nome', 'like', '%' . $request->busca . '%');
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

        if (count($categoria) < 1) {
            //Redirecionamento para a rota de cadastro de categoria, com mensagem
            return redirect()->route('categoriaCursoCadastro')->with('atencao', 'Para cadastrar um curso é necessário antes cadastrar uma categoria!');
        }

        if (count($professor) < 1) {
            //Redirecionamento para a rota de cadastro de professor, com mensagem
            return redirect()->route('professorCadastro')->with('atencao', 'Para cadastrar um curso é necessário antes cadastrar um professor!');
        }

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
            'tipo' => 'required',
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
        $item->aula_travada = $request->aula_travada;
        $item->tipo = $request->tipo;
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
    Função Editar de Curso
    - Responsável por mostrar a tela de edição de Curso
    - $item: Recebe o Id do Curso que deverá ser editado
    */
    public function editar($id, $menu = null)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $item = Curso::join('categoria_cursos', 'cursos.categoria_id', '=', 'categoria_cursos.id')
            ->where('cursos.status', '<>', '0')
            ->orderby('cursos.nome', 'asc')
            ->where('cursos.status', '<>', '0')
            ->selectRaw('cursos.*, categoria_cursos.nome as categoria')
            ->find($id);

        //Verifica se há alguma categoria de curso  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('cursoIndex')->with('atencao', 'Curso excluido!');
            }

            $categorias = CategoriaCurso::where('status', '=', '1')->get();

            $aulas = Aula::where('curso_id', '=', $item->id)->where('status', '<>', '0')
                ->orderByRaw('-ordem desc')
                ->orderby('ordem', 'desc')
                ->get();

            $professor = Professor::find($item->professor_id);

            //Exibe a tela de edição de categoria de curso passando parametros para view
            return view('painelAdmin.curso.editar', [
                'item' => $item,
                'menu' => $menu,
                'categorias' => $categorias,
                'aulas' => $aulas,
                'professor' => $professor
            ]);
        } else {
            //Redirecionamento para a rota CursoIndex, com mensagem de erro
            return redirect()->route('cursoIndex')->with('erro', 'Curso não encontrado!');
        }
    }

    /*
    Função Salvar de Curso
    - Responsável por editar as informações de uma categoria de curso já cadastrado
    - $request: Recebe valores de uma categoria de curso
    - $item: Recebe uma objeto de Curso vázio para edição
    */
    public function salvar(Request $request, Curso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoadmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:100',
            'categoria' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->cooprodutor = $request->cooprodutor;
        $item->categoria_id = $request->categoria;
        $item->descricao = $request->descricao;
        $item->tipo = $request->tipo;
        $item->aula_travada = $request->aula_travada;
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->aula_teste = $request->aula_teste;
        $item->porcentagem_solicitacao_certificado = $request->porcentagem_solicitacao_certificado;

        //Verificação se uma nova imagem de imagem foi informado, caso seja verifica-se sua integridade
        if (@$request->file('imagem') and $request->file('imagem')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $imagemApagar = $item->imagem;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->imagem = $request->imagem->store('imagemCurso');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->imagem))
                ->hexa('#FFFFFF')
                ->redimensiona(570, 450, 'preenchimento')
                ->redimensiona('80%')
                ->grava(public_path('storage/' . $item->imagem), 100);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {
            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$imagemApagar and Storage::exists($imagemApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($imagemApagar);
            }
            //Redirecionamento para a rota CursoIndex, com mensagem de sucesso
            return redirect()->route('cursoEditar', [$item])->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Curso
    - Responsável por excluir as informações de uma Curso
    - $request: Recebe o Id do uma Curso a ser excluido
    */
    public function deletar(Curso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoCurso, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Curso informado
        if ($item->save()) {

            //Redirecionamento para a rota CursoIndex, com mensagem de sucesso
            return redirect()->route('cursoIndex')->with('sucesso', 'Curso excluido!');
        } else {
            //Redirecionamento para a rota CursoIndex, com mensagem de erro
            return redirect()->route('cursoIndex')->with('erro', 'Curso não excluido!');
        }
    }

    /*
    Função status de Curso
    - Responsável por exibir o status do Curso
    - $status: Recebe o Id do status do Curso
    */
    public function status($status)
    {
        //Verifica o status do Curso
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


    /*
    Função tipo de Curso
    - Responsável por exibir o tipo do Curso
    - $tipo: Recebe o Id do tipo do Curso
    - sempre que passar esse comando pra view passe conforme o exemplo:
        {{ app(App\Http\Controllers\CursoController::class)->tipo($item->tipo, true) }} o true identifica o 2° parametro $tipoSite

    */
    public function tipo($tipo, $tipoSite = '')
    {
        //Verifica o tipo do Curso
        switch ($tipo) {
            case 1:
                if ($tipoSite == 1) {
                    //se tiver o true, exibe a primeira opção
                    return 'Curso Iniciante';
                } else {
                    //caso passe apenas tipo, exibe a segunda opção
                    return 'Curso Iniciante | Até 5 Aulas | R$ 18,00';
                }
                break;

            case 2:
                if ($tipoSite == 2) {
                    //se tiver o true, exibe a primeira opção
                    return 'Curso Intermediário';
                } else {
                    //caso passe apenas tipo, exibe a segunda opção
                    return 'Curso Intermediário | Até 10 Aulas | R$ 26,00';
                }
                break;

            case 3:
                if ($tipoSite == 3) {
                    //se tiver o true, exibe a primeira opção
                    return 'Curso Avançado';
                } else {
                    //caso passe apenas tipo, exibe a segunda opção
                    return 'Curso Avançado | Mais de 15 Aulas | R$ 38,00';
                }

                break;

            case 4:
                //Retorna o tipo Treinamento
                return 'Treinamento';
                break;

            case 0:
                //Retorna o tipo Excluido
                return 'Excluido';
                break;
        }
    }

    public function codigo_tipo($tipo)
    {
        //Verifica o tipo do Curso
        switch ($tipo) {
            case 1:
                return 'I';
                break;

            case 2:
                return 'M';
                break;

            case 3:
                return 'A';
                break;

            case 4:
                return 'T';
                break;
        }
    }

    /*
    Função visibilidade de Curso
    - Responsável por exibir o visibilidade do curso
    - $visibilidade: Recebe o Id do visibilidade do curso
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do curso
        switch ($visibilidade) {
            case 1:
                //Retorna o visibilidade Vísivel
                return 'Visível';
                break;

            case 2:
                //Retorna o visibilidade Não Vísivel
                return 'Não Visível';
                break;
        }
    }

    /*
    Função Aula Travada de Curso
    - Responsável por exibir a Aula Travada do curso
    - $aula_travada: Recebe o Id do visibilidade do curso
    */
    public function aula_travada($aula_travada)
    {
        //Verifica o visibilidade do curso
        switch ($aula_travada) {
            case 1:
                //Retorna o visibilidade Vísivel
                return 'Sim';
                break;

            case 2:
                //Retorna o visibilidade Não Vísivel
                return 'Não';
                break;
        }
    }
}
