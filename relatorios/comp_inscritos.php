<?php
//iniciando acessão
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8');
//classes do frame work
require ("../vendor/autoload.php");
require ("../class_arquitetura/biblioteca.php");
require ("../class_arquitetura/conexao.php");
require ("../class_arquitetura/persistencia.php");
require ("../class_modelo/classes.php");
include ("lib_relatorios.php");
$conn = Conexao::init();
$root = new Persistencia();
$oAss = new Associacao();
$oInsc = new Inscricao();
$oeve = new Competicao();
$lib = new libRelatorio();
$logo = '../img/logo.png';
//$mpdftags = $lib -> setCabecalhoRodapePadrao($logo, $_REQUEST['titulo']);
$oeve->getById($_REQUEST['evento']);
$sql = "select a.* from " . Associacao::TABELA . " a inner join " . Atleta::TABELA . " b on b.idAssociacao = a.id inner join " . Inscricao::TABELA . " c on c.idAtleta = b.id where c.idCompeticao = " . $_REQUEST['evento'];

if($_REQUEST['associacao'] != ""){
$sql .= " and a.id = ".$_REQUEST['associacao'];
}
$sql .= " group by a.id";

//echo $_REQUEST['associacao'].$sql;
//exit();

$rs = $oAss -> getSQL($sql);
$html = "<h2>".$oeve->titulo."</h2>";
foreach ($rs as $key => $value) {
	$html .= $value -> nome . "<hr/>";
	$html .= "<table class='grade' ><tr><th>Classe</th><th>Categoria</th><th>Atleta</th><th>Número</th><th>1ª dobra</th><th>2ª dobra</th><th>3ª dobra</th></tr>";
	$sqli = "select i.* from ".Inscricao::TABELA." i inner join ".Atleta::TABELA." a on a.id = i.idAtleta where a.idAssociacao = ".$value->id." and i.idCompeticao = ".$_REQUEST['evento'];
	if(isset($_REQUEST['pago'])){
	$sqli .= " and i.situacao = 1 ";
	}else{
	$sqli .= " and i.situacao < 2 ";	
	}
	$sqli .= " order by i.idClasse, i.idCategoria";
	$rsInsc = $oInsc -> getSQL($sqli);
	
	foreach ($rsInsc as $key2 => $inscricao) {
		$html .= "<tr><td>".$inscricao->classe->descricao."</td><td>".$inscricao->categoria->descricao."</td><td>".$inscricao->atleta->pessoa->nome." ".$inscricao->atleta->pessoa->nomeMeio." ".$inscricao->atleta->pessoa->sobrenome."</td><td>".$inscricao->atleta->getId()."</td>";
		if($inscricao->dobra1 != null) $html .= "<td>".$inscricao->dobra1->classe->descricao.'-'.$inscricao->dobra1->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra2 != null) $html .= "<td>".$inscricao->dobra2->classe->descricao.'-'.$inscricao->dobra2->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra3 != null) $html .= "<td>".$inscricao->dobra3->classe->descricao.'-'.$inscricao->dobra3->descricao."</td>"; else $html .= "<td>-</td>";
		$html .=  "</tr>";
	}
	$html .= "</table>";
}

if($oeve->tipo == 2){
//atletas sem ligacao com associacao
	$html .= "ATLETAS CADASTRADOS SEM ASSOCIAÇÃO<hr/>";
	$html .= "<table class='grade' ><tr><th>Classe</th><th>Categoria</th><th>Atleta</th><th>Número</th><th>Associação do Responsável</th><th>1ª dobra</th><th>2ª dobra</th><th>3ª dobra</th></tr>";
	$sqli = "select i.* from ".Inscricao::TABELA." i where i.idAtleta is null and i.idCompeticao = ".$_REQUEST['evento'];	
	if($_REQUEST['associacao'] != ""){
	$sqli .= " and i.idAssociacao = ".$_REQUEST['associacao'];	
	}
	if(isset($_REQUEST['pago'])){
	$sqli .= " and i.situacao = 1 ";
	}else{
	$sqli .= " and i.situacao < 2 ";	
	}
	$sqli .= " order by i.idClasse, i.idCategoria";
	$rsInsc = $oInsc -> getSQL($sqli);
	
	foreach ($rsInsc as $key2 => $inscricao) {
		$html .= "<tr><td>".$inscricao->classe->descricao."</td><td>".$inscricao->categoria->descricao."</td><td>".$inscricao->nomeAtleta."</td><td>".$inscricao->id."</td><td>".$inscricao->associacao->nome."</td>";
		if($inscricao->dobra1 != null) $html .= "<td>".$inscricao->dobra1->classe->descricao.'-'.$inscricao->dobra1->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra2 != null) $html .= "<td>".$inscricao->dobra2->classe->descricao.'-'.$inscricao->dobra2->descricao."</td>"; else $html .= "<td>-</td>";
		if($inscricao->dobra3 != null) $html .= "<td>".$inscricao->dobra3->classe->descricao.'-'.$inscricao->dobra3->descricao."</td>"; else $html .= "<td>-</td>";
		$html .=  "</tr>";
	}
	$html .= "</table>";

}
//==============================================================
//==============================================================
//==============================================================
//$stylesheet = file_get_contents('../../../css/pdf.css');
//echo '<style>'.$stylesheet.'</style>'.$mpdftags.$html;
//exit();
//$mpdf = new mPDF('c', 'A4', '', '', 20, 20, 30, 25, 5, 5);
//$mpdf -> WriteHTML($stylesheet, 1);
//$mpdf -> mirrorMargins = 0;
// Use different Odd/Even headers and footers and mirror margins
//$mpdf -> WriteHTML(utf8_encode($mpdftags . $html));

//$mpdf -> Output('relat_inscritos.pdf','I');

$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch','setAutoBottomMargin' => 'stretch','defaultCssFile'=>URI.'/css/pdf.css']);

    $mpdf->SetHTMLHeader(utf8_encode($lib->cabecalhoPadrao($_REQUEST['titulo'],$logo)));
	$mpdf->SetHTMLFooter(utf8_encode($lib->rodapePadrao()));
	//$mpdf->Write($stylesheet);
    $mpdf->WriteHTML(utf8_encode($html));

    $mpdf->Output('/tmp/relat_inscritos.pdf','I');
exit ;
//==============================================================
//==============================================================
//==============================================================
?>