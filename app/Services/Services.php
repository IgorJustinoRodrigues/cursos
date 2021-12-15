<?php
//Namespace do arquivo
namespace App\Services;

use App\Models\Config;
use DateTime;

//Class AdminController
class Services
{
    /*
    Função Validar Admin
    - Responsável por verificar se há uma sessão ativa de um admin
    */
    public function validarAdmin()
    {
        //Inícia a Sessão
        @session_start();

        //Verifica se não existe uma sessão ativa de admin
        if (!isset($_SESSION['admin_cursos_start']) or !is_numeric($_SESSION['admin_cursos_start']['id_admin'])) {
            //Expira a sessão
            unset($_SESSION['admin_cursos_start']);
            return false;

        } else {
            //Redirecionamento para a rota sairAdmin após 10 minutos sem uma nova requisição
            header("Refresh:6000; url=" . route('sairAdmin'));

            //Retorna verdade para a sessão ativa
            return true;
        }
    }
    
    public function redirecionar(){
        return redirect()->route('acessoAdmin')->with('erro', 'Para acessar esse conteúdo é necessário fazer login no sistema!');
    }

    public function data_atual(){
        return $this->diaSemana(date('w')) . ', ' . date('d') . ' de ' . $this->mes(date('n'));
    }

    public function mes($mes) {
        switch ($mes) {
            case 1:
                return "Janeiro";
                break;

            case 2:
                return "Fevereiro";
                break;

            case 3:
                return "Março";
                break;

            case 4:
                return "Abril";
                break;

            case 5:
                return "Maio";
                break;

            case 6:
                return "Junho";
                break;
            
            case 7:
                return "Julho";
                break;
            
            case 8:
                return "Agosto";
                break;
            
            case 9:
                return "Setembro";
                break;
            
            case 10:
                return "Outubro";
                break;
            
            case 11:
                return "Novembro";
                break;
            
            case 12:
                return "Dezembro";
                break;
        }
    }
    
    public function diaSemana($dia) {
        switch ($dia) {
            case 0:
                return "Domingo";
                break;

            case 1:
                return "Segunda-feira";
                break;

            case 2:
                return "Terça-feira";
                break;

            case 3:
                return "Quarta-feira";
                break;

            case 4:
                return "Quinta-feira";
                break;

            case 5:
                return "Sexta-feira";
                break;

            case 6:
                return "Sábado";
                break;
        }
    }
}
