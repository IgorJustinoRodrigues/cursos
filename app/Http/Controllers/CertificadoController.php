<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Mpdf\Mpdf;

class CertificadoController extends Controller
{
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
                </style>

                <div id="frente">
                    <h1>Igor Justino Rodrigues</h1>
                    <h2>Segurança Digital</h2>
                    <img src="' . $logo_parceiro . '" alt="' . $alt . '" width="150px" />
                    <h3>Móveis Estrela</h3>
                    <p>www.facamaisbrasil.com.br/parceiro/4/moveis-estrela.html</p>
                    <p>Emitido em 31 de janeiro de 2022</p>
                    <p>Nome completo do Aluno<br>CPF: 123*******3</p>
                </div>
                <br>
                <div id="verso">
                    <h2>Segurança Digital</h2>
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
                    <img src="' . $qrcode . '" alt="' . $alt . '" width="150px" height="150px" />
                    <p>
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
