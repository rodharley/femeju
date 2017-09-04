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

$lib = new libRelatorio();
$logo = '../../../img/logo.png';
$mpdftags = $lib -> setCabecalhoRodapePadrao($logo, "Relatório Receita vs Despesas");

$html = "<h2>Período: ".$_REQUEST['datai']." - ".$_REQUEST['dataf']."</h2>";

$objDesp = new Despesa();
$objPag = new Pagamento();
$datai = $objDesp->convdata($_REQUEST['datai'],"ntm");
$dataf = $objDesp->convdata($_REQUEST['dataf'],"ntm");
$rs = $objDesp->pesquisa($datai,$dataf);
$rs2 = $objPag->pesquisaRelatorio($datai, $dataf);

$arrayRelat = array();
$arrayDatas = array();
$i = 0;
$total =  0;
foreach ($rs as $key => $value) {
	$arrayRelat[$i]['data'] = $objDesp->convdata($value->data,"mtn");
	$arrayRelat[$i]['valor'] = $objDesp->money(-$value->valor,"atb");
	$arrayRelat[$i]['descricao'] = $value->descricao;
	$arrayRelat[$i]['parcela'] = $value->parcela."/".$value->grupo->parcelas;
	$arrayDatas[$i] = $objDesp->limpaDigitos($value->data);
	$i++;
	$total -= $value->valor;
}
foreach ($rs2 as $key => $value) {
	$arrayRelat[$i]['data'] = $objDesp->convdata($value->dataPagamento,"mtn");
	$arrayRelat[$i]['valor'] = $objDesp->money($value->valorTotal,"atb");
	$arrayRelat[$i]['descricao'] = $value->descricao;
	$arrayRelat[$i]['parcela'] = "1/1";
	$arrayDatas[$i] = $objDesp->limpaDigitos($value->dataPagamento);
	$total += $value->valorTotal;
	$i++;
}
array_multisort($arrayDatas, $arrayRelat);

$html .= "<table class='grade' ><tr><th>Data</th><th>Descrição</th><th>Parcela</th><th>Valor</th></tr>";
foreach ($arrayRelat as $key => $value) {
	$html .= "<tr><td>".$value['data']."</td>";		
	$html .= "<td>".$value['descricao']."</td>";
	$html .= "<td>".$value['parcela']."</td>";
	$html .= "<td align='right'>R$ ".$value['valor']."</td></tr>";
}
	$html .= "<tr><th colspan='3' align='right'>Saldo:</th><th align='right'>R$ ".$objDesp->money($total,"atb")."</th></tr>";
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

$mpdf -> Output('receitavsdespesa.pdf', 'I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>