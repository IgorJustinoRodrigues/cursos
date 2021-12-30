<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Services\Services;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{

 
    /*
    Função Index de Unidade
    - Responsável por mostrar a tela de listagem de parceiros 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Unidade::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de unidade passando parametros para view
        return view('painelAdmin.unidade.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Unidade
    - Responsável por mostrar a tela de cadastro de parceiroistradores
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de parceiroistradores
        return view('painelAdmin.parceiro.cadastro');
    }

    /*
    Função Inserir de Unidade
    - Responsável por inserir as informações de um novo parceiroistrador
    - $request: Recebe valores do novo parceiroistrador
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => 'required|max:20|unique:parceiros,usuario',
        ]);

        //Nova instância do Model Unidade
        $item = new Unidade();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        $item->senha = '123456';
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->sobre = $request->sobre;

        //Verificação se imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoUnidade');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        } else {
            //Atribuição de valor padrão para imagem logo caso o mesmo não seja informado 
            $item->logo = null;
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Unidade
    - Responsável por mostrar a tela de edição de parceiroistradores
    - $item: Recebe o Id do parceiro que deverá ser editado
    */
    public function editar(Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum parceiro selecionado
        if (@$item) {

            if($item->status == 0){
                return redirect()->route('parceiroIndex')->with('atencao', 'Unidade excluido!');
            }

            //Exibe a tela de edição de parceiroistradores passando parametros para view
            return view('painelAdmin.parceiro.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'Unidade não encontrado!');
        }
    }

    /*
    Função Salvar de Unidade
    - Responsável por editar as informações de um parceiroistrador já cadastrado
    - $request: Recebe valores de um parceiroistrador
    - $item: Recebe uma objeto de Unidade vázio para edição
    */
    public function salvar(Request $request, Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => "required|max:20|unique:parceiros,usuario,{$item->id}"
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->sobre = $request->sobre;


        //Verificação se uma nova imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $logoApagar = $item->logo;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoUnidade');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$logoApagar and Storage::exists($logoApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($logoApagar);
            }

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Unidade
    - Responsável por excluir as informações de um parceiro
    - $request: Recebe o Id do um parceiro a ser excluido
    */
    public function deletar(Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o parceiroi informado
        if ($item->save()) {

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', 'Unidade excluido!');
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'Unidade não excluido!');
        }
    }


    /*
    Função Resetar Senha de Unidade
    - Responsável por Resetar a senha de um parceiro
    - $request: Recebe o Id do um parceiro para a senha ser resetada
    */
    public function reseteSenha(Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o parceiroi informado
        if ($item->save()) {

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


    /*
    Função Login de Unidade
    - Responsável pelo login do parceiroistrador ao painel
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

        //Seleciona o parceiro no banco de dados, usando as credencias de acesso
        $item = Unidade::where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();

        //Verifica se existe um parceiro com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do parceiro encontrado
            $logado['id_parceiro'] = $item->id;
            $logado['nome_parceiro'] = $item->nome;
            $logado['logo_parceiro'] = $item->logo;
            $logado['usuario_parceiro'] = $item->usuario;
            $logado['status_parceiro'] = $item->status;
            $logado['visibilidade_parceiro'] = $item->visibilidade;
            $logado['cadastro_parceiro'] = $item->created_at->format('d/m/Y') . ' às ' . $item->created_at->format('H:i');
            $logado['ultimo_acesso_parceiro'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

            //Cria uma sessão com as informações
            $_SESSION['parceiro_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('parceiro_usuario', $request->usuario, 4320);
                Cookie::queue('parceiro_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('parceiro_usuario');
                Cookie::expire('parceiro_senha');
            }

            //Atualiza a data e hora do campo updated_at
            $item->touch();

            //Redirecionamento para a rota painelUnidade, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelUnidade')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de parceiros!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Unidade
    - Responsável pelo logoff do painel do parceiro
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['parceiro_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoUnidade')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função status de Unidade
    - Responsável por exibir o status do parceiro
    - $status: Recebe o Id do status do parceiro
    */
    public function status($status)
    {
        //Verifica o status do parceiro
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
    Função visibilidade de Unidade
    - Responsável por exibir o visibilidade do parceiro
    - $visibilidade: Recebe o Id do visibilidade do parceiro
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do parceiro
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
}
