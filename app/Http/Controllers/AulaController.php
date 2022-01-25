<?php

namespace App\Http\Controllers;

use App\Models\AnexoAula;
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

        //Função que apaga todas as perguntas e respostas de um curso
        function apagarQuiz($curso)
        {
            $perguntasApagar = Perguntas::join('aulas', 'aulas.id', '=', 'perguntas.aulas_id')
                ->where('curso_id', '=', $curso)
                ->selectRaw('aulas.id as aula_id, perguntas.id as pergunta_id')
                ->get();

            foreach ($perguntasApagar as $apagar) {
                $respostasApagarItem = Respostas::where('pergunta_id', '=', $apagar->pergunta_id)->get();

                foreach ($respostasApagarItem as $apagarRespostaItem) {
                    $apagarRespostaItem->delete();
                }
                $itemApagar = Perguntas::find($apagar->pergunta_id);
                $itemApagar->delete();
            }
        }

        switch ($request->tipo) {
            case 1:
                //Vídeo
                $validated = $request->validate([
                    'video' => 'required',
                ]);

                //Atribui valores
                $item->avaliacao = 0;
                $item->video = $request->video;
                $item->texto = $request->texto;

                //Apaga o Quiz caso exista
                apagarQuiz($curso->id);

                break;

            case 2:
                //Texto
                $validated = $request->validate([
                    'texto' => 'required',
                ]);

                //Atribui valores
                $item->texto = $request->texto;
                $item->avaliacao = 0;
                $item->video = null;

                //Apaga o Quiz caso exista
                apagarQuiz($curso->id);

                break;

            case 3:
                //Quiz
                $validated = $request->validate([
                    'perguntas.*' => 'required'
                ]);

                //Atribui valores
                $item->avaliacao = $request->avaliacao;
                $item->texto = null;
                $item->video = null;

                //Lista as perguntas do curso
                $perguntas = Perguntas::where('aulas_id', '=', $item->id)->get();

                //Verifica se existe perguntas, se não, cria um array vázio
                if (count($perguntas) > 0) {
                    //Cria o array com os id
                    $arrayPerguntas = Arr::pluck($perguntas, 'id');
                } else {
                    $arrayPerguntas = array();
                }

                //Verifica se foi enviado perguntas no formulário, se não, cria um array vázio
                $arrayPerguntasRequest = $request->id_perguntas ? $request->id_perguntas : [];

                //Compara os array e gera um novo array que deve ser apagado do banco, caso seja necessário
                $perguntasApagar = array_diff($arrayPerguntas, $arrayPerguntasRequest);

                //Percorre os ids de perguntas que devem ser excluidos
                foreach ($perguntasApagar as $apagar) {
                    //Consulta no banco o registro que será apagado
                    $itemApagar = Perguntas::find($apagar);

                    //Lista as respostas que existem para a pergunta que será excluida
                    $respostasApagarItem = Respostas::where('pergunta_id', '=', $apagar)->get();

                    //Percorre os ids das respostas que devem ser excluidas
                    foreach ($respostasApagarItem as $apagarRespostaItem) {
                        //Consulta no banco o registro que será apagado
                        $itemRespostaApagar = Respostas::find($apagarRespostaItem->id);
                        //Realiza a exclusão
                        $itemRespostaApagar->delete();
                    }

                    //Realiza a exclusão
                    $itemApagar->delete();
                }

                //Contador para buscar as informações array do request
                $i = 0;
                //Contador para acessar os indices das respostas do request
                $j = 1;

                //Recebe o array dos ids enviados pelo request para atualizar as informações da pergunta no banco, caso não exista, atribui array vázio
                $arrayIdsRequest = $request->id_perguntas ? $request->id_perguntas : [];

                //percorre os ids enviados, mesmo que não exista um id, neste caso insere um novo registro 
                foreach ($arrayIdsRequest as $linha) {
                    //Verifica se existe id
                    if ($linha) {
                        //Existindo, realiza a busca do registro no banco pelo id 
                        $pergunta = Perguntas::find($linha);
                    } else {
                        //Não existindo, cria uma nova instancia e prepara para inserção
                        $pergunta = new Perguntas();
                        $pergunta->aulas_id = $item->id;
                    }

                    //Atribui as informações enviadas
                    $pergunta->pergunta = $request->perguntas[$i];

                    //Insere ou salva o registro
                    $pergunta->save();

                    //Lista as respotas da pergunta criada ou salva
                    $respostas = Respostas::where('pergunta_id', '=', $linha)->get();
                    //Verifica se existe perguntas no banco
                    if (count($respostas) > 0) {
                        //Cria o array com os id
                        $arrayRespostas = Arr::pluck($respostas, 'id');
                    } else {
                        $arrayRespostas = array();
                    }

                    #########################################
                    ## Devido a um erro de sintaxe foi necessário fazer a atribuição dos valores para um novo vetor
                    ## -----------------------------
                    ## O Procedimento está presente nas próximas linhas
                    #########################################

                    //Cria nomes de indices com o contador $J
                    $indiceRespostaId = "id" . $j;
                    $indiceRespostaOpcao = "opcao" . $j;
                    $indiceRespostaResposta = "resposta" . $j;
                    //Cria array com os ids enviados pelo request ou um array vázio
                    $arrayRequest = $request->input($indiceRespostaId) ? $request->input($indiceRespostaId) : [];

                    //Cria um array vázio
                    $arrayResposta = [];

                    //Percorre array enviado pelo request
                    foreach ($arrayRequest as $linha2) {
                        //Atribui os valores para um novo array
                        $arrayResposta[] = $linha2;
                    }

                    #########################################
                    ## FIM DO PROCEDIMENTO
                    #########################################

                    //Compara os array e gera um novo array que deve ser apagado do banco, caso seja necessário
                    $respostasApagar = array_diff($arrayRespostas, $arrayResposta);

                    //Percorre o array que deverá ser apagado de Respostas
                    foreach ($respostasApagar as $apagar) {
                        //Seleciona a resposta do banco
                        $itemApagar = Respostas::find($apagar);
                        //Deleta o registro
                        $itemApagar->delete();
                    }

                    //Contador para acessar os indices da resposta e opção da resposta enviada
                    $y = 0;
                    //Cria array com os ids de resposta enviados pelo request ou um array vázio
                    $arrayRequestRespostaId = $request->input($indiceRespostaId) ? $request->input($indiceRespostaId) : [];
                    //percorre os ids de resposta enviados, mesmo que não exista um id, neste caso insere um novo registro 
                    foreach ($arrayRequestRespostaId as $linha3) {
                        //Verifica se existe id
                        if ($linha3) {
                            //Existindo, realiza a busca do registro no banco pelo id 
                            $resposta = Respostas::find($linha3);
                        } else {
                            //Não existindo, cria uma nova instancia e prepara para inserção
                            $resposta = new Respostas();
                            $resposta->pergunta_id = $pergunta->id;
                        }

                        //Atribui as informações
                        $resposta->resposta = $request->input($indiceRespostaResposta)[$y];
                        $resposta->correta = $request->input($indiceRespostaOpcao)[$y];

                        //Insere ou salva o registro
                        $resposta->save();

                        //Incrementa o contador
                        $y++;
                    }

                    //Incrementa o contador
                    $i++;
                    $j++;
                }

                break;

            default:
                //Erro

                //Redirecionamento para tela anterior com mensagem de erro
                return redirect()->back()->with('atencao', 'Encontramos um erro, tente novamente!');

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
    public function deletar(Curso $curso, Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $item->status = 0;

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex', $curso->id)->with('sucesso', 'Aula excluida!');
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


        $item->senha = md5('123456');

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'A senha não pode ser resetada!');
        }
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
    public function tipo($tipo, $avaliacao = '', $icone = false)
    {
        //Verifica o tipo da aual
        switch ($tipo) {
            case 1:
                if ($icone) {
                    return '<i class="material-icons">ondemand_video</i>';
                } else {
                    return 'Vídeo';
                }
                break;

            case 2:
                if ($icone) {
                    return '<i class="material-icons">format_align_left</i>';
                } else {
                    return 'Texto';
                }
                break;

            case 3:
                if ($avaliacao == 1) {
                    if ($icone) {
                        return '<i class="material-icons">grade</i>';
                    } else {
                        return 'Quiz Avaliativo';
                    }
                } else {
                    if ($icone) {
                        return '<i class="material-icons">dvr</i>';
                    } else {
                        return 'Quiz';
                    }
                }
                break;
        }
    }

    public function inserirAnexo(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $item = new AnexoAula();
        $item->aula_id = $request->aula_id;
        $item->nome = $request->file('arquivo')->getClientOriginalName();

        //Verificação se imagem de imagem foi informado, caso seja verifica-se sua integridade
        if (@$request->file('arquivo') and $request->file('arquivo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'arquivo' => 'required|max:10240'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->arquivo = $request->arquivo->store('anexoAula');
        }

        //Envio das informações para o banco de dados
        $item->save();

        //Verificação do insert
        echo ('"' . $request->file('arquivo')->getClientOriginalName() . '" enviado com sucesso!');
    }

    public function listarAnexo(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $anexo = AnexoAula::where('aula_id', '=', $request->id)
            ->selectRaw('*, date_format(created_at, "%d/%m/%H às %H:%i") as data')
            ->get();

        if (count($anexo) > 0) {
            $retorno = [
                'status' => 1,
                'anexos' => $anexo
            ];
        } else {
            $retorno = [
                'msg' => 'Não há anexos!',
                'status' => 0
            ];
        }

        //Resposta JSON
        return response()->json($retorno);
    }

    public function deletarAnexo(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $anexo = AnexoAula::find($request->id);
        if($anexo->delete()){
            $arquivoApagar = $anexo->arquivo;

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$arquivoApagar and Storage::exists($arquivoApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($arquivoApagar);
            }

            $retorno = [
                'msg' => 'Anexo excluido!',
                'status' => 1
            ];
        } else {
            $retorno = [
                'msg' => 'Não foi possível excluir o anexo!',
                'status' => 0
            ];
        }

        //Resposta JSON
        return response()->json($retorno);
    }

    public function msgNota($nota)
    {
        if ($nota < 60) {
            return "Você não atingiu a média, tente novamente!";
        } else if ($nota < 80) {
            return "Aula concluida!";
        } else {
            return "Parabéns! Aula concluida.";
        }
    }
}
