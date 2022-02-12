<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Aula;
use App\Models\AulaAluno;
use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Parceiro;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Mpdf\Mpdf;

class CertificadoController extends Controller
{
    public function solicitar(Request $request, $url = '')
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Validação das informações recebidas
        $validated = $request->validate([
            'id_curso' => 'required'
        ], [
            'id_curso.required' => "O curso não foi informado corretamente!"
        ]);

        $curso = Curso::where("status", '=', 1)->find($request->id_curso);
        if ($curso) {
            //Inícia a Sessão
            @session_start();

            $certificado = Certificado::where('curso_id', '=', $curso->id)
            ->where('aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
            ->where('status', '<>', '0')
            ->first();

            if($certificado){
                //Redirecionamento para tela anterior com mensagem de erro
                return redirect()->back()->with('padrao', 'Você já possui um certificado para o curso informado!');
            }

            $matricula = Matricula::where('curso_id', '=', $curso->id)
            ->where('aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
            ->where('status', '<>', 0)
            ->orderBy('updated_at', 'desc')
            ->orderBy('status', 'desc')
            ->first();

            if ($matricula) {

                $aulas = Aula::where('aulas.curso_id', '=', $curso->id)
                    ->where('aulas.status', '=', '1')
                    ->orderByRaw('-ordem desc')
                    ->orderby('ordem', 'desc')
                    ->get();

                $aulas_feitas = AulaAluno::where('aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
                    ->where('curso_id', '=', $curso->id)
                    ->whereNotNull('conclusao')
                    ->get();

                $minutos_feitos = 0;
                $minutos_total = 0;
                $ids_feitos = data_get($aulas_feitas, '*.aula_id');

                for ($i = 0; $i < count($aulas); $i++) {
                    if (in_array($aulas[$i]->id, $ids_feitos)) {
                        $minutos_feitos += $aulas[$i]->duracao;
                    }
                    
                    $minutos_total += $aulas[$i]->duracao;
                }

                if ($minutos_feitos > 0) {
                    $porcentagem = ($minutos_feitos * 100) / $minutos_total;
                } else {
                    $porcentagem = 0;
                }

                if($porcentagem >= $curso->porcentagem_solicitacao_certificado){
                    $total = 0;

                    foreach($aulas_feitas as $linha){
                        $total += $linha->nota;
                    }

                    $media = $total / (count($aulas_feitas));

                    $parceiro = Parceiro::join('unidades', 'unidades.parceiro_id', '=', 'parceiros.id')
                    ->where('unidades.id', '=', $matricula->unidade_id)
                    ->first();

                    //Exibe a view
                    return view('painelAluno.certificado.solicitacao', [
                        'curso' => $curso,
                        'parceiro' => $parceiro,
                        'minutos_feitos' => $minutos_feitos,
                        'minutos_total' => $minutos_total,
                        'porcentagem' => $porcentagem,
                        'media' => $media
                    ]);
                } else {
                    //Redirecionamento para tela anterior com mensagem de erro
                    return redirect()->back()->with('atencao', 'Você ainda não atingiu a porcentagem necessária para solicitar o certificado!');
                }
            } else {
                //Redirecionamento para tela anterior com mensagem de erro
                return redirect()->back()->with('atencao', 'Você não está matrículado(a) neste curso!');
            }
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'O curso informado não está disponível!');
        }
    }

    public function pdf()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'Padaukbook'
        ]);

        $url = "certificado/validar/";
        $tamanho = "170"; //Define o tamanho da imagem em px
        $qrcode = "http://chart.apis.google.com/chart?chs=" . $tamanho . "x" . $tamanho . "&cht=qr&chl=" . $url;
        $alt = "Use um leitor de QR-Code para abrir esta página";

        $logo_parceiro = URL::asset('storage/logoParceiro/3Mx0FTIZ00BLjrDLF05QgQ7aWbwP2HiGJSDux2HI.jpg');

        $html = '
        <html>
            <head>
            </head>
            <body>
                <style> 
                    #frente{
                        font-family: font-family: Verdana, Arial, Helvetica, sans-serif;
                        background: url(\'' . URL::asset('imagem/certificado/fundo-frente.jpg') . '\') no-repeat;
                        height: 100%;
                        width: 100%;
                        background-size: cover;
                    }

                    #verso{
                        font-family: font-family: Verdana, Arial, Helvetica, sans-serif;
                        background: url(\'' . URL::asset('imagem/certificado/fundo-verso.jpg') . '\') no-repeat;
                        height: 100%;
                        width: 100%;
                        background-size: cover;
                    }

                    H1{
                        padding-top: 345px;
                        margin: auto;
                        width: 700px;
                        height: 110px;
                        text-align: center;
                        font-size:40px;
                        line-height: 1.1;
                        font-weight: bold;
                        font-style: italic;
                    }
                    
                    .curso-frente{
                        padding-top: 15px;
                        margin: auto;
                        width: 700px;
                        height: 70px;
                        text-align: center;
                        font-size:25px;
                        line-height: 1.1;
                        font-weight: normal;
                    }

                    H3{
                        font-size:15px;
                    }

                    .link-parceiro{
                        font-style: italic;
                        padding-top: -10px;
                        font-size:12px;
                        width: 350px;
                        height: 30px;
                    }
                    
                    .logo-parceiro{
                        padding-top: 118px;
                        padding-left: 150px;
                    }

                    .info-parceiro{
                        padding-top: -70px;
                        padding-left: 328px;
                    }

                    .emissao{
                        padding-top: 15px;
                        margin: auto;
                        width: 700px;
                        height: 20px;
                        text-align: center;
                        font-size:18px;
                        font-weight: bold;
                        font-style: italic;
                    }

                    .assinatura-aluno{
                        padding-top: 140px;
                        margin: auto;
                        width: 700px;
                        text-align: center;
                        font-size:13px;
                        font-weight: bold;
                        font-style: italic;
                    }

                    .curso-verso{
                        padding-top: 250px;
                        padding-left: 70px;
                        width: 650px;
                        height: 70px;
                        font-size:25px;
                        line-height: 1.1;
                        font-weight: bold;
                        font-style: italic;
                    }

                    h4{
                        padding-top: -10px;
                        padding-left: 70px;
                        width: 650px;
                        height: 40px;
                        font-size:18px;
                        font-weight: nomal;
                        font-style: italic;
                        color: #8d8d8d;
                    }
                    
                    h5{
                        padding-top: -10px;
                        padding-left: 70px;
                        width: 650px;
                        height: 40px;
                        font-size:18px;
                        font-weight: nomal;
                        font-style: italic;
                    }

                    .qr{
                        padding-top: 365px;
                        padding-left: 30px;
                    }

                    .link-qr{
                        padding-top: -60px;
                        padding-left: 180px;
                        font-style: italic;
                        font-size:12px;
                    }
                </style>

                <div id="frente">
                    <h1>Igor Justino Rodrigues</h1>
                    <h2 class="curso-frente">Segurança Digitals</h2>
                        <div class="logo-parceiro">
                            <img src="' . $logo_parceiro . '" alt="' . $alt . '" width="150px"/>
                        </div>
                        <div class="info-parceiro">
                            <h3>Centro Educacional Start - Carmo do Rio Verde / GO</h3>
                            <p class="link-parceiro">www.facamaisdfsbrasil.csdsfslfdsfsdfsdfsfdsdfsdfsdfsdfsdsfa.html</p>
                        </div>
                    <p class="emissao">Emitido em 31 de janeiro de 2022</p>
                    <p class="assinatura-aluno">Nome completo do Aluno<br>CPF: 123*******3</p>
                </div>
                <br>
                <div id="verso">
                    <h2 class="curso-verso">Segurança Digital </h2>
                    <h4>Informática</h4>
                    <h5>
                        Matrícula: 2XXXCACCEA20I22<br>
                        Iniciante<br>
                        <br>
                        * Carga Horária: 20h<br>
                        * 9 Aulas<br>
                        * Média de Aprovação: 85%<br>
                        * Data de Conclusão: 25/01/2022<br>
                    </h5>
                    <img class="qr" src="' . $qrcode . '" alt="' . $alt . '" width="150px" height="150px" />
                    <p class="link-qr">
                        Este certificado pode ser validado fazendo a leitura desse QR Code<br>
                        ou acessando o link: https://www.facamaisbrasil.com.br/validar/ABC123
                    </p>
                </div>
            </body>
        </html>
            ';

        $mpdf->AddPage('', '', '', '', '', 0, 0, 0, 0);
        $mpdf->WriteHTML($html);

        $mpdf->SetTitle("Certificado");
        $mpdf->Output();
    }
}
