<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Canvas;
use App\Models\Curso;
use App\Models\Perguntas;
use App\Models\Respostas;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class AulaController extends Controller
{
    /*
    Função Index de Aula
    - Responsável por mostrar a tela de listagem de aulas 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $items = Aula::where('curso_id', '=', $curso->id)
            ->where('status', '<>', '0')
            ->orderByRaw('-ordem desc')
            ->orderby('ordem', 'desc')
            ->get();

        //Exibe a tela de listagem de aula passando parametros para view
        return view('painelAdmin.aula.index', ['curso' => $curso, 'item' => $items]);
    }

    /*
    Função Cadastro de Aula
    - Responsável por mostrar a tela de cadastro de aula
    */
    public function cadastro(Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de aula
        return view('painelAdmin.aula.cadastro', ['curso' => $curso]);
    }

    /*
    Função Inserir de Aula
    - Responsável por inserir as informações de um novo aulaistrador
    - $request: Recebe valores do novo aulaistrador
    */
    public function inserir(Request $request, Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo' => 'required',
            'nome' => 'required',
            'duracao' => 'required',
        ]);

        //Nova instância do Model Aula
        $item = new Aula();

        //Atribuição dos valores recebidos da váriavel $request
        $item->tipo = $request->tipo;
        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->duracao = $request->duracao;
        $item->status = 2;
        $item->ordem = null;
        $item->avaliacao = $request->avaliacao;
        $item->curso_id = $curso->id;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaEditar', [$curso, $item])->with('sucesso', 'Aula: "' . $item->nome . '", cadastrada!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Aula
    - Responsável por mostrar a tela de edição de aula
    - $item: Recebe o Id do aula que deverá ser editado
    */
    public function editar(Curso $curso, Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum aula selecionado
        if (@$item) {
            if ($item->status == 0) {
                return redirect()->route('aulaIndex', $curso)->with('atencao', 'Aula excluido!');
            }

            $perguntas = Perguntas::where('aulas_id', '=', $item->id)->get();

            for ($i = 0; $i < count($perguntas); $i++) {
                $perguntas[$i]->respostas = Respostas::where('pergunta_id', '=', $perguntas[$i]->id)->get();
            }

            //Exibe a tela de edição de aula passando parametros para view
            return view('painelAdmin.aula.editar', [
                'item' => $item,
                'curso' => $curso,
                'perguntas' => $perguntas
            ]);
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'Aula não encontrado!');
        }
    }

    /*
    Função Salvar de Aula
    - Responsável por editar as informações de um aulaistrador já cadastrado
    - $request: Recebe valores de um aulaistrador
    - $item: Recebe uma objeto de Aula vázio para edição
    */
    public function salvar(Request $request, Curso $curso, Aula $item)
    {

        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo' => 'required',
            'nome' => 'required',
            'duracao' => 'required',
            'status' => 'required',
        ]);

        switch ($request->tipo) {
            case 1:
                //Vídeo
                $validated = $request->validate([
                    'video' => 'required',
                ]);

                $item->avaliacao = 0;

                break;

            case 2:
                //Texto
                $validated = $request->validate([
                    'texto' => 'required',
                ]);

                $item->avaliacao = 0;

                break;

            case 3:
                //Quiz
                $validated = $request->validate([
                    'perguntas.*' => 'required'
                ]);

                $item->avaliacao = $request->avaliacao;

                $perguntas = Perguntas::where('aulas_id', '=', $item->id)->get();

                if(count($perguntas) > 0){
                    $arrayPerguntas = Arr::pluck($perguntas, 'id');
                } else {
                    $arrayPerguntas = array();
                }

                $arrayPerguntasRequest = $request->id_perguntas ? $request->id_perguntas : [];

                $perguntasApagar = array_diff($arrayPerguntas, $arrayPerguntasRequest);

                foreach ($perguntasApagar as $apagar) {
                    $itemApagar = Perguntas::find($apagar);

                    $respostasApagarItem = Respostas::where('pergunta_id', '=', $apagar)->get();

                    foreach($respostasApagarItem as $apagarRespostaItem){
                        $itemRespostaApagar = Respostas::find($apagarRespostaItem->id);
                        $itemRespostaApagar->delete();
                    }

                    $itemApagar->delete();
                }

                $i = 0;
                $j = 1;

                $arrayIdsRequest = $request->id_perguntas ? $request->id_perguntas : [];

                foreach ($arrayIdsRequest as $linha) {


                    if ($linha) {
                        $pergunta = Perguntas::find($linha);
                    } else {
                        $pergunta = new Perguntas();
                        $pergunta->aulas_id = $item->id;
                    }

                    $pergunta->pergunta = $request->perguntas[$i];

                    $pergunta->save();

                    $respostas = Respostas::where('pergunta_id', '=', $linha)->get();
                    if(count($respostas) > 0){
                        $arrayRespostas = Arr::pluck($respostas, 'id');
                    } else {
                        $arrayRespostas = array();
                    }

                    $indiceRespostaId = "id" . $j;
                    $indiceRespostaOpcao = "opcao" . $j;
                    $indiceRespostaResposta = "resposta" . $j;
                    $arrayRequest = $request->input($indiceRespostaId) ? $request->input($indiceRespostaId) : [];

                    $arrayResposta = [];
 
                    foreach ($arrayRequest as $linha2) {
                        $arrayResposta[] = $linha2;
                    }

                    $respostasApagar = array_diff($arrayRespostas, $arrayResposta);

                    foreach ($respostasApagar as $apagar) {
                        $itemApagar = Respostas::find($apagar);
                        $itemApagar->delete();
                    }

                    $y = 0;
                    $arrayRequestRespostaId = $request->input($indiceRespostaId) ? $request->input($indiceRespostaId) : [];
                    foreach ($arrayRequestRespostaId as $linha3) {
                        
                        if ($linha3) {
                            $resposta = Respostas::find($linha3);
                        } else {
                            $resposta = new Respostas();
                            $resposta->pergunta_id = $pergunta->id;
                        }
                        $resposta->resposta = $request->input($indiceRespostaResposta)[$y];
                        $resposta->correta = $request->input($indiceRespostaOpcao)[$y];
    
                        $resposta->save();
                        $y++;
                }    
                    
                    $i++;
                    $j++;
                }

                break;

            default:
                //Erro
                break;
        }

        //Atribuição dos valores recebidos da váriavel $request
        $item->tipo = $request->tipo;
        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->duracao = $request->duracao;
        $item->status = $request->status;
        $item->curso_id = $curso->id;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {
            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaEditar', [$curso->id, $item])->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Aula
    - Responsável por excluir as informações de um aula
    - $request: Recebe o Id do um aula a ser excluido
    */
    public function deletar(Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', 'Aula excluido!');
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'Aula não excluido!');
        }
    }


    /*
    Função Resetar Senha de Aula
    - Responsável por Resetar a senha de um aula
    - $request: Recebe o Id do um aula para a senha ser resetada
    */
    public function reseteSenha(Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


    /*
    Função Login de Aula
    - Responsável pelo login do aulaistrador ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Validação das informações recebidas
        $validated = $request->validate([
            'usuario' => 'required|max:20',
            'senha' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $usuario = $request->usuario;
        $senha = $request->senha;

        //Seleciona o aula no banco de dados, usando as credencias de acesso
        $item = Aula::where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();

        //Verifica se existe um aula com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do aula encontrado
            $logado['id_aula'] = $item->id;
            $logado['nome_aula'] = $item->nome;
            $logado['logo_aula'] = $item->logo;
            $logado['usuario_aula'] = $item->usuario;
            $logado['status_aula'] = $item->status;
            $logado['visibilidade_aula'] = $item->visibilidade;
            $logado['cadastro_aula'] = $item->created_at->format('d/m/Y') . ' às ' . $item->created_at->format('H:i');
            $logado['ultimo_acesso_aula'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

            //Cria uma sessão com as informações
            $_SESSION['aula_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('aula_usuario', $request->usuario, 4320);
                Cookie::queue('aula_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('aula_usuario');
                Cookie::expire('aula_senha');
            }

            //Atualiza a data e hora do campo updated_at
            $item->touch();

            //Redirecionamento para a rota painelAula, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAula')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de aulas!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Aula
    - Responsável pelo logoff do painel do aula
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['aula_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoAula')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    public function ordenar(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $ids = json_decode($request->ids);
        $ordems = json_decode($request->ordems);

        $i = 0;
        foreach ($ids as $id) {
            $aula = Aula::where('curso_id', '=', $request->curso_id)->find($id);

            if ($aula) {
                $aula->ordem = $ordems[$i++];

                if (!$aula->save()) {
                    $retorno = [
                        'msg' => 'Não foi possível ordenar as aulas!',
                        'status' => 0
                    ];

                    return response()->json($retorno);
                    exit;
                }
            } else {
                $retorno = [
                    'msg' => 'Não foi possível ordenar as aulas!',
                    'status' => 0
                ];

                return response()->json($retorno);
                exit;
            }
        }

        $retorno = [
            'msg' => 'Aulas reordenadas!',
            'status' => 1
        ];

        //Resposta JSON
        return response()->json($retorno);
    }

    /*
    Função status de Aula
    - Responsável por exibir o status do aula
    - $status: Recebe o Id do status do aula
    */
    public function status($status)
    {
        //Verifica o status do aula
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
    Função visibilidade de Aula
    - Responsável por exibir o visibilidade do aula
    - $visibilidade: Recebe o Id do visibilidade do aula
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do aula
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
    Função tipo de Aula
    - Responsável por exibir o tipo da Aula
    - $tipo: Recebe o Id do tipo da aula
    */
    public function tipo($tipo, $avaliacao = '')
    {
        //Verifica o tipo da aual
        switch ($tipo) {
            case 1:
                return 'Texto';
                break;

            case 2:
                return 'Vídeo';
                break;

            case 3:
                if ($avaliacao == 1) {
                    return 'Quiz Avaliativo';
                } else {
                    return 'Quiz';
                }
                break;
        }
    }
}
