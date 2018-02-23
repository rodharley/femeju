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
$oAss = new Associacao();
$oInsc = new Inscricao();
$oeve = new Competicao();
$lib = new libRelatorio();
$logo = '../../../img/logo.png';
$mpdftags = $lib -> setCabecalhoRodapePadrao($logo, $_REQUEST['titulo']);
$oeve->getById($_REQUEST['evento']);
$sql = "select a.* from " . Associacao::TABELA . " a inner join " . Atleta::TABELA . " b on b.idAssociacao = a.id inner join " . Inscricao::TABELA . " c on c.idAtleta = b.id where c.idCompeticao = " . $_REQUEST['evento'];
if($_REQUEST['associacao'] != ""){
$sql .= " and a.id = ".$_REQUEST['associacao'];
}
$sql .= " group by a.id";
$total = 0;

$rs = $oAss -> getSQL($sql);
$html = "<h2>".$oeve->titulo."</h2>";
foreach ($rs as $key => $value) {
	$subtotal = 0;
	$html .= $value -> nome . "<hr/>";
	$html .= "<table class='grade' ><tr><th>Classe</th><th>Categoria</th><th>Atleta</th><th>Número</th><th>1ª dobra</th><th>2ª dobra</th><th>3ª dobra</th><th>Valor</th></tr>";
	$sqli = "select i.* from ".Inscricao::TABELA." i inner join ".Atleta::TABELA." a on a.id = i.idAtleta where a.idAssociacao = ".$value->id." and i.idCompeticao = ".$_REQUEST['evento'];
	if(isset($_REQUEST['pago'])){
	$sqli .= " and i.situacao = 1 ";
	}
	$sqli .= " order by i.idClasse, i.idCategoria";
	$rsInsc = $oInsc -> getSQL($sqli);
	
	foreach ($rsInsc as $key2 => $inscricao) {
		$valorAtleta = $inscricao->valor+$inscricao->valorDobra1+$inscricao->valorDobra2+$inscricao->valorDobra3;
		$html .= "<tr><td>".$inscricao->classe->descricao."</td><td>".$inscricao->categoria->descricao."</td><td>".$inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome."</td><td>".$inscricao->atleta->getId()."</td>";
		if($inscricao->dobra1 != null) $html .= "<td>".$inscricao->dobra1->classe->descricao.'-'.$inscricao->dobra1->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra2 != null) $html .= "<td>".$inscricao->dobra2->classe->descricao.'-'.$inscricao->dobra2->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra3 != null) $html .= "<td>".$inscricao->dobra3->classe->descricao.'-'.$inscricao->dobra3->descricao."</td>"; else $html .= "<td>-</td>";
		$html .="<td  class='texto-right'>R$ ".$inscricao->money($valorAtleta,"atb")."</td>";
		$html .=  "</tr>";
		$total += $valorAtleta;
		$subtotal += $valorAtleta;
	}
	$html .="<tr><td colspan='7' style='text-align:right;'>Total Associação:</td><td style='text-align:right;'>R$".$oAss->money($subtotal,"atb")."</td></tr>";
	$html .= "</table>";
}

if($oeve->tipo == 2 && $_REQUEST['associacao'] == ""){
//atletas sem ligacao com associacao
	$subtotal = 0;
	$html .= "ATLETAS MODALIDADE ABERTA<hr/>";
	$html .= "<table class='grade' ><tr><th>Classe</th><th>Categoria</th><th>Atleta</th><th>Número</th><th>Associação do Responsável</th><th>1ª dobra</th><th>2ª dobra</th><th>3ª dobra</th><th>Valor</th></tr>";
	$sqli = "select i.* from ".Inscricao::TABELA." i where i.idAtleta is null and i.idCompeticao = ".$_REQUEST['evento'];
	if(isset($_REQUEST['pago'])){
	$sqli .= " and i.situacao = 1 ";
	}
	$sqli .= " order by i.idClasse, i.idCategoria";
	$rsInsc = $oInsc -> getSQL($sqli);
	
	foreach ($rsInsc as $key2 => $inscricao) {
		$valorAtleta = $inscricao->valor+$inscricao->valorDobra1+$inscricao->valorDobra2+$inscricao->valorDobra3;
		$html .= "<tr><td>".$inscricao->classe->descricao."</td><td>".$inscricao->categoria->descricao."</td><td>".$inscricao->nomeAtleta."</td><td>".$inscricao->id."</td><td>".$inscricao->associacao->nome."</td>";
		if($inscricao->dobra1 != null) $html .= "<td>".$inscricao->dobra1->classe->descricao.'-'.$inscricao->dobra1->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra2 != null) $html .= "<td>".$inscricao->dobra2->classe->descricao.'-'.$inscricao->dobra2->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra3 != null) $html .= "<td>".$inscricao->dobra3->classe->descricao.'-'.$inscricao->dobra3->descricao."</td>"; else $html .= "<td>-</td>";
		$html .="<td style='text-align:right;'>R$ ".$inscricao->money($valorAtleta,"atb")."</td>";
		$html .=  "</tr>";
		$total += $valorAtleta;
		$subtotal += $valorAtleta;
	}
	$html .="<tr><td colspan='8' style='text-align:right;'>Total Atletas:</td><td style='text-align:right;'>R$ ".$oAss->money($subtotal,"atb")."</td></tr>";
	$html .= "</table>";
	}
	$html .="<table class='grade' ><tr><td style='text-align:right;'>Total:</td><td width='20%' style='text-align:right;'>R$ ".$oAss->money($total,"atb")."</td></tr></table>";

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

$mpdf -> Output('relat_analitico.pdf','I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>