<?php
//iniciando acess�o
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8 ');
//classes do frame work
require ("../vendor/autoload.php");

$arrayatletas = explode(",",$_REQUEST['atletas']);
foreach ($arrayatletas as $key => $value) {
if($key == 0)
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8',
'format' => [210, 297],
'orientation' => 'P',
    'mirrorMargins' => 0,
    'margin_left'=>0,
    'margin_right'=>0,
    'margin_top'=>0,
    'margin_bottom'=>0,
    'margin_header'=>0,
    'margin_footer'=>0]);
else    
$mpdf->AddPage();
$mpdf->WriteHTML("<img src='../img/pessoas/carteira_frente".str_pad($value,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>");
$mpdf->AddPage();
$mpdf->WriteHTML("<img src='../img/pessoas/carteira_verso".str_pad($value,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>");
unlink("../img/pessoas/carteira_frente".str_pad($value,5,"0",STR_PAD_LEFT).".png");
unlink("../img/pessoas/carteira_verso".str_pad($value,5,"0",STR_PAD_LEFT).".png");    
}
$mpdf->mirrorMargins = 0; 
$mpdf->Output('impressao.pdf','D');
//unlink("../../../img/pessoas/".$_GET['id'].".png");
//unlink("../../../img/pessoas/carteira".$_GET['id'].".png");
exit;
//==============================================================
//==============================================================
//==============================================================


?>