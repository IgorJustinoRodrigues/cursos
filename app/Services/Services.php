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

    public function redirecionar()
    {
        return redirect()->route('acessoAdmin')->with('erro', 'Para acessar esse conteúdo é necessário fazer login no sistema!');
    }

    /*
    Função Validar Aluno
    - Responsável por verificar se há uma sessão ativa de um aluno
    */
    public function validarAluno()
    {
        //Inícia a Sessão
        @session_start();

        //Verifica se não existe uma sessão ativa de aluno
        if (!isset($_SESSION['aluno_cursos_start']) or !is_numeric($_SESSION['aluno_cursos_start']->id)) {
            //Expira a sessão
            unset($_SESSION['aluno_cursos_start']);
            return false;
        } else {
            //Retorna verdade para a sessão ativa
            return true;
        }
    }

    public function redirecionarAluno()
    {
        return redirect()->route('acessoAluno')->with('erro', 'Para acessar esse conteúdo é necessário fazer login no sistema!');
    }


    /*
    Função Validar Parceiro
    - Responsável por verificar se há uma sessão ativa de um parceiro
    */
    public function validarParceiro()
    {
        //Inícia a Sessão
        @session_start();

        //Verifica se não existe uma sessão ativa de parceiro
        if (!isset($_SESSION['parceiro_cursos_start']) or !is_numeric($_SESSION['parceiro_cursos_start']['id_parceiro'])) {
            //Expira a sessão
            unset($_SESSION['parceiro_cursos_start']);
            return false;
        } else {
            //Redirecionamento para a rota sairParceiro após 10 minutos sem uma nova requisição
            header("Refresh:6000; url=" . route('sairParceiro'));

            //Retorna verdade para a sessão ativa
            return true;
        }
    }

    public function redirecionarParceiro()
    {
        return redirect()->route('acessoParceiro')->with('erro', 'Para acessar esse conteúdo é necessário fazer login no sistema!');
    }


    public function data_atual()
    {
        return $this->diaSemana(date('w')) . ', ' . date('d') . ' de ' . $this->mes(date('n'));
    }

    public function mes($mes)
    {
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

    public function diaSemana($dia)
    {
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

    function minuto_hora($minutos)
    {
        $retorno = "";

        $hora = floor($minutos / 60);

        if ($hora > 0) {
            //Existe hora ou horas
            $resto = $minutos % 60;
            if ($hora > 1) {
                $retorno .= $hora . ' horas';
            } else {
                $retorno .= $hora . ' hora';
            }
            if ($resto > 0) {
                if ($resto > 1) {
                    $retorno .= ' ' . $resto . ' minutos';
                } else {
                    $retorno .= ' ' . $resto . ' minuto';
                }
            }
        } else {
            //Existe apenas minutos
            if ($minutos == 1) {
                $retorno .= $minutos . ' minuto';
            } else {
                $retorno .= $minutos . ' minutos';
            }
        }
        return $retorno;
    }

    function primeiro_pagamento($primeiro_mes = false, $segundo_mes = false, $primeiro_mes_simples = false, $segundo_mes_simples = false){
        if($segundo_mes_simples){
            //2º MÊS SIMPLES
            $retorno = date('m', strtotime('+1 months', strtotime(date('Y-m')))) . '/' . date('Y', strtotime('+1 months', strtotime(date('Y-m'))));          
        } else if($primeiro_mes_simples) {
            //1º MÊS SIMPLES
            $retorno = date('m') . '/' . date('Y');
        } else if($segundo_mes) {
            //2º MÊS
            $retorno = $this->mes(date('m', strtotime('+1 months', strtotime(date('Y-m'))))) . '/' . date('Y', strtotime('+1 months', strtotime(date('Y-m'))));
        } else {
            //2º MÊS
            $retorno = $this->mes(date('m')) . '/' . date('Y');
        }

        return $retorno;
    }
}
