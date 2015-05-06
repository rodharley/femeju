<?php
//iniciando acessão
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8');
//classes do frame work
require("../../class_arquitetura/biblioteca.php");
require("../../class_arquitetura/conexao.php");
require("../../class_arquitetura/persistencia.php");
require("../../class_modelo/classes.php");	
include("../mpdf.php");
include("../lib_relatorios.php");
$conn = Conexao::init();
$lib = new libRelatorio();
$empresa  = new Empresa();
if($_SESSION['fmj.empresaId'] != 0){
	$empresa->getById($_SESSION['fmj.empresaId']);
	$logo = '../../img/logomarcas/'.$empresa->logomarca;
}else{
	$logo = '../../img/logo.png';
}

$mpdftags = $lib->setCabecalhoRodapePadrao($empresa, $logo, $_REQUEST['titulo']);
$html = $_REQUEST['conteudo'];
//==============================================================
//==============================================================
//==============================================================
$stylesheet = file_get_contents('../../css/pdf.css');
//echo '<style>'.$stylesheet.'</style>'.$mpdftags.$html;
//exit();


$mpdf=new mPDF('c','A4','','',20,20,30,25,5,5); 

$mpdf->WriteHTML($stylesheet,1);
$mpdf->mirrorMargins = 0;	// Use different Odd/Even headers and footers and mirror margins
$mpdf->WriteHTML(utf8_encode($mpdftags.$html));

$mpdf->Output();
exit;
//==============================================================
//==============================================================
//==============================================================


?>