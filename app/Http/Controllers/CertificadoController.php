<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class CertificadoController extends Controller
{
    public function pdf()
    {
        
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf->AddPage('L', '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->WriteHTML('olá');
        $mpdf->Output();

    }
}
