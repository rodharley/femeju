<?php
//iniciando acessão
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8 ');
//classes do frame work
require ("../vendor/autoload.php");
require ("../class_arquitetura/biblioteca.php");
require ("../class_arquitetura/conexao.php");
require ("../class_arquitetura/persistencia.php");
require ("../class_modelo/classes.php");
include ("lib_relatorios.php");
$conn = Conexao::init();
$objDiploma = new Diploma();
$objDiploma->getById($_REQUEST['diploma']);
$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch','setAutoBottomMargin' => 'stretch','format' => 'A4-L']);
    

$layout= $objDiploma->layout;
$row = 0;
$html = "";
if (($handle = fopen($_FILES['arquivo']['tmp_name'], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if($row > 0){
		$mpdf->AddPage();
		}        	
        $num = count($data);
		$texto = $layout;
		for($i=0;$i<$num;$i++){
			$texto = str_replace("#CAMPO".($i+1)."#", $data[$i], $texto);
		}
        $mpdf -> WriteHTML(utf8_encode($texto));
		
		$row++;
    }
    fclose($handle);
}

/*
$arrayatletas = explode(",",$_REQUEST['atletas']);
foreach ($arrayatletas as $key => $value) {
if($key == 0)
    $mpdf=new mPDF('c','A4','','',0,0,0,0,5,5);
else    
    $mpdf->AddPage();
$mpdf->WriteHTML("<img src='../../../img/pessoas/carteira_frente".str_pad($value,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>");
$mpdf->AddPage();
$mpdf->WriteHTML("<img src='../../../img/pessoas/carteira_verso".str_pad($value,5,"0",STR_PAD_LEFT).".png' width='204' height='325'/>");
unlink("../../../img/pessoas/carteira_frente".str_pad($value,5,"0",STR_PAD_LEFT).".png");
unlink("../../../img/pessoas/carteira_verso".str_pad($value,5,"0",STR_PAD_LEFT).".png");    
}*/

$mpdf->WriteHTML(utf8_encode($html));

$mpdf -> Output('diploma.pdf', 'I');
//unlink("../../../img/pessoas/".$_GET['id'].".png");
//unlink("../../../img/pessoas/carteira".$_GET['id'].".png");
exit;
//==============================================================
//==============================================================
//==============================================================


?>