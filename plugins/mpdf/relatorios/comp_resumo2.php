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
$html = "<h2>".$oeve->titulo."</h2>";
$html .= "<table class='grade' ><tr><th>Associação</th></tr>";
foreach ($rs as $key => $associacao) {
	$html .= "<tr><td>".$associacao->nome."</td></tr>";
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

$mpdf -> Output('relat_resumo.pdf', 'I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>