<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Services\Services;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function InserirNewsletter(Request $request)
    {
        //Verifica se já existe o email enviado
        $verifica = Newsletter::where('email', '=', $request->email)->first();

        if($verifica){
            //Caso exista

            //Verifica o statos do registro
            if($verifica->status == 1){
                //Resposta que email já esta cadastrado
                $retorno = [
                    'msg' => 'O e-mail informado já está cadastrado!',
                    'status' => 2
                ];
            } else {
                //Caso onde o email existe porem está inativo

                //Verifica o nome enviado
                $validated = $request->validate([
                    'nome' => 'required'
                ]);

                //Atribui o nome enviado ao registro e o status com ativo
                $verifica->nome = $request->nome;
                $verifica->status = 1;

                //Salva
                $verifica->save();

                //Retorno de sucesso
                $retorno = [
                    'msg' => 'Sua Inscrição foi realizada com sucesso',
                    'status' => 1
                ];
            }
        } else {
            //Validação das informações recebidas
            $validated = $request->validate([
                'nome' => 'required',
                'email' => 'required|email|max:200'
            ]);

            //Recebe os dados Enviados do internauta. 
            $item = new Newsletter();      

            $item->nome = $request->nome;
            $item->email = $request->email;
            //Hash da data com hora atual
            $item->hash = md5(date('dmYHis'));
            $item->status = 1;

            //Salva
            $resposta = $item->save();

            //Verifica se salvou
            if ($resposta) {
                //Resposta de sucesso
                $retorno = [
                    'msg' => 'Sua Inscrição foi realizada com sucesso',
                    'status' => 1
                ];
            } else {
                //Resposta de erro
                $retorno = [
                    'msg' => 'Não foi possível realizar a sua inscrição',
                    'status' => 0
                ];
            }
        }
        
        //Retorno json
        return response()->json($retorno);
    }

       /*
    Função Status de Newsletter
    - Responsável por exibir o Newsletter da Mensagem
    - $status: Recebe o Id do Newsletter da Mensagem
    */
    public function status($status)
    {
        //Verifica o status do Mensagem
        switch ($status) {
            case 1:
                //Retorna o status Mensagem
                return 'Ativo';
                break;

            case 2:
                //Retorna o status da Mensagem 
                return 'Inativo';
                break;
        }
    }

}
