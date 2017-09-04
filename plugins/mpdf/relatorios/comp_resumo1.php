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
$oeve -> getById($_REQUEST['evento']);
$sql = "select a.* from " . Associacao::TABELA . " a inner join " . Atleta::TABELA . " b on b.idAssociacao = a.id inner join " . Inscricao::TABELA . " c on c.idAtleta = b.id where c.idCompeticao = " . $_REQUEST['evento'];
$sql .= " group by a.id";
$rs = $oAss -> getSQL($sql);
$sqli = "select i.* from " . Inscricao::TABELA . " i where i.idCompeticao = " . $_REQUEST['evento'];
$rsInsc = $oInsc -> getSQL($sqli);

$totalAtletas = count($rsInsc);
$totalAtletasGeral = 0;
$totalAtletaPago = 0;
$totalAtletaNaoPago = 0;
$valorTotalAtletas = 0;
$valorTotalNaoPago = 0;
$valorTotalPago = 0;
foreach ($rsInsc as $key => $inscricao) {
	$valorAtleta = $inscricao->valor+$inscricao->valorDobra1+$inscricao->valorDobra2+$inscricao->valorDobra3;
	$valorTotalAtletas += $valorAtleta;
	if ($inscricao -> situacao == 0) {
		$totalAtletaNaoPago++;
		$valorTotalNaoPago += $valorAtleta;
	} else {
		$totalAtletaPago++;
		$valorTotalPago += $valorAtleta;
	}
	$totalAtletasGeral++;
	if ($inscricao -> dobra1 != null)
		$totalAtletasGeral++;
	if ($inscricao -> dobra2 != null)
		$totalAtletasGeral++;
	if ($inscricao -> dobra3 != null)
		$totalAtletasGeral++;
}
$html = "<h2>".$oeve->titulo."</h2>";

$html .= "<table class='grade' ><tr><th>Estatística</th><th>Contagem</th><th>Valor</th></tr>";
$html .= "<tr><td>Associações Inscritas</td><td style='text-align:right;'>" . count($rs) . "</td><td style='text-align:right;'>-</td></tr>";
$html .= "<tr><td>Atletas Inscritos</td><td style='text-align:right;'>" . $totalAtletas . "</td><td style='text-align:right;'>R$ ".$oAss->money($valorTotalAtletas,"atb")."</td></tr>";
$html .= "<tr><td>Atletas Total (Normal + Dobras)</td><td style='text-align:right;'>" . $totalAtletasGeral . "</td><td style='text-align:right;'>-</td></tr>";
$html .= "<tr><td>Total Não Pago</td><td style='text-align:right;'>" . $totalAtletaNaoPago . "</td><td style='text-align:right;'>R$ ".$oAss->money($valorTotalNaoPago,"atb")."</td></tr>";
$html .= "<tr><td>Total Pago</td><td style='text-align:right;'>" . $totalAtletaPago . "</td><td style='text-align:right;'>R$ ".$oAss->money($valorTotalPago,"atb")."</td></tr>";
$html .= "<tr><td>Total Teórico</td><td style='text-align:right;'>" . $totalAtletas . "</td><td style='text-align:right;'>R$ ".$oAss->money($valorTotalAtletas,"atb")."</td></tr>";
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

$mpdf -> Output('relat_resumo.pdf', 'I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>