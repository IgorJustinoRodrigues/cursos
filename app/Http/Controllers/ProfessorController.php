<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Canvas;
use App\Models\Professor;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessorController extends Controller
{

    /*
    Função Index de Professor
    - Responsável por mostrar a tela de listagem de professors 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Professor::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de professores passando parametros para view
        return view('painelAdmin.professor.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Professor
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de professor
        return view('painelAdmin.professor.cadastro');
    }

    /*
    Função Inserir de Professor
    - Responsável por inserir as informações de um novo professor
    - $request: Recebe valores do novo professor
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
        ]);

        //Nova instância do Model Professor
        $item = new Professor();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->facebook = $request->facebook;
        $item->instagram = $request->instagram;
        $item->linkedin = $request->linkedin;
        $item->site = $request->site;
        $item->curriculo = $request->curriculo;
        $item->status = $request->status;

        //Verificação se imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarProfessor');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        } else {
            //Atribuição de valor padrão para imagem avatar caso o mesmo não seja informado 
            $item->avatar = null;
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota professorIndex, com mensagem de sucesso
            return redirect()->route('professorIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Professor
    - Responsável por mostrar a tela de edição de Professor
    - $item: Recebe o Id do professor que deverá ser editado
    */
    public function editar(Professor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoProfessor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum professor selecionado
        if (@$item) {

            if($item->status == 0){
                return redirect()->route('professorIndex')->with('atencao', 'Professor excluido!');
            }

            //Exibe a tela de edição de professor passando parametros para view
            return view('painelAdmin.professor.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota professorIndex, com mensagem de erro
            return redirect()->route('professorIndex')->with('erro', 'Professor não encontrado!');
        }
    }

    /*
    Função Salvar de Professor
    - Responsável por editar as informações de um professor já cadastrado
    - $request: Recebe valores de um professor
    - $item: Recebe uma objeto de Professor vázio para edição
    */
    public function salvar(Request $request, Professor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoProfessor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

         //Atribuição dos valores recebidos da váriavel $request
         $item->nome = $request->nome;
         $item->email = $request->email;
         $item->facebook = $request->facebook;
         $item->instagram = $request->instagram;
         $item->linkedin = $request->linkedin;
         $item->site = $request->site;
         $item->curriculo = $request->curriculo;
         $item->status = $request->status;


        //Verificação se uma nova imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $avatarApagar = $item->avatar;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarProfessor');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota professorIndex, com mensagem de sucesso
            return redirect()->route('professorIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Professor
    - Responsável por excluir as informações de um professor
    - $request: Recebe o Id do um professor a ser excluido
    */
    public function deletar(Professor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoProfessor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o professor informado
        if ($item->save()) {

            //Redirecionamento para a rota professorIndex, com mensagem de sucesso
            return redirect()->route('professorIndex')->with('sucesso', 'Professor excluido!');
        } else {
            //Redirecionamento para a rota professorIndex, com mensagem de erro
            return redirect()->route('professorIndex')->with('erro', 'Professor não excluido!');
        }
    }


   
    /*
    Função status de Professor
    - Responsável por exibir o status do professor
    - $status: Recebe o Id do status do professor
    */
    public function status($status)
    {
        //Verifica o status do professor
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
