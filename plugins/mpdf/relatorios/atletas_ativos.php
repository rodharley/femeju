<?php
//iniciando acessão
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8');
//classes do frame work
require ("../../../class_arquitetura/biblioteca.php");
require ("../../../class_arquitetura/conexao.php");
require ("../../../class_arquitetura/persistencia.php");
require ("../../../class_modelo/classes.php");
include ("../mpdf.php");
include ("../lib_relatorios.php");
$conn = Conexao::init();
$root = new Persistencia();
$oAtleta = new Atleta();
$lib = new libRelatorio();
$logo = '../../../img/logo.png';
$mpdftags = $lib -> setCabecalhoRodapePadrao($logo, $_REQUEST['titulo']);

$rs = $oAtleta -> getRows(0,99999,array("numeroFemeju"=>"ASC"),array("ativo"=>"=1"));
$html = "<table class='grade' ><tr><th>Número</th><th>Nome</th><th>CPF</th><th>Faixa</th></tr>";
foreach ($rs as $key => $value) {
	$html .= "<tr><td>" . $value -> numeroFemeju . "</td><td>" . $value -> pessoa -> getNomeCompleto() . "</td><td>" . $value -> pessoa ->cpf . "</td><td>" . $value -> graduacao -> faixa . "</td></tr>";
	
	
	
}
$html .= "</table>";

//==============================================================
//==============================================================
//==============================================================
$stylesheet = file_get_contents('../../../css/pdf.css');
//echo '<style>'.$stylesheet.'</style>'.$mpdftags.$html;
//exit();
$mpdf = new mPDF('c', 'A4', '', '', 20, 20, 30, 25, 5, 5);
$mpdf -> WriteHTML($stylesheet, 1);
$mpdf -> mirrorMargins = 0;
// Use different Odd/Even headers and footers and mirror margins
$mpdf -> WriteHTML(utf8_encode($mpdftags . $html));

$mpdf -> Output('relat_atletas_ativos.pdf','I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>