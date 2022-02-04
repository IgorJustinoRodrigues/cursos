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
        //Recebe os dados Enviados do internauta. 
        $item = new Newsletter();

        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->hash = md5(123);

        $resposta = $item->save();

        if ($resposta) {
            $retorno = [
                'msg' => 'Sua Inscrição foi realizada com sucesso',
                'status' => 1
            ];
        } else {
            $retorno = [
                'msg' => 'Não foi possível realizar a sua inscrição',
                'status' => 0
            ];
        }

        return response()->json($retorno);
    }

}
