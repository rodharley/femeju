<?php
//iniciando acessão
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8');
//classes do frame work
include("../mpdf.php");

$mpdf=new mPDF('c','A4','','',20,20,30,25,5,5); 
$mpdf->WriteHTML("<img src='../../../img/pessoas/carteira".$_GET['id'].".png'/>");
$mpdf->mirrorMargins = 0;	// Use different Odd/Even headers and footers and mirror margins
$mpdf->Output('carteira_femeju.pdf','D');
unlink("../../../img/pessoas/".$_GET['id'].".png");
unlink("../../../img/pessoas/carteira".$_GET['id'].".png");
exit;
//==============================================================
//==============================================================
//==============================================================


?>