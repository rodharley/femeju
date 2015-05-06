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

$mpdftags = $lib->setCabecalhoRodapePadrao($empresa, $logo, "Relatório <br/>Logs de Acesso");
$texto = $_REQUEST['texto'];
$strEmpresa = $_REQUEST['empresa'];
$condominio = $_REQUEST['condominio'];
$usuario = $_REQUEST['usuario'];
$periodo = $_REQUEST['periodo'];
$log = new Log();

$html = '<h2>Lista de Logs do Sistema</h2>';
$html .= 'Termo Pesquisado: '.$texto."<br/>";	
$html .= '<table class="tabelaComum" cellspacing="0"><tr><th>IP</th><th>Data</th><th>Usuário</th><th>Navegador</th><th>URL</th><th>Log</th></tr>';
$lista = $log->pesquisa($texto,$strEmpresa,$condominio,$usuario,$periodo);
foreach ($lista as $key => $l) {
$user =	$l->usuario != null ? $l->usuario->nome : '-';
if(strpos($l->navegador,"Firefox") === false){
	if(strpos($l->navegador,"Chrome") === false){
		if(strpos($l->navegador,"MSIE") === false){
			if(strpos($l->navegador,"Opera") === false){
				$navegador = 'nav-safari.png';
				}else{
				$navegador = 'nav-opera.png';		
			}
		}else{
		$navegador = 'nav-ie.png';		
		}
	}else{
	$navegador = 'nav-chrome.png';		
	}
}else{	
$navegador = 'nav-firefox.png';	
}
$html .= '<tr><td>'.$l->ip.'</td>
<td>'.$l->convdata($l->data,"mtnh").'</td>
<td>'. $user .'</td>
<td><img src="../../img/'.$navegador.'" width="32"/></td>
<td>'.$l->url.'</td>
<td>'.$l->texto.'</td>
</tr>';
}
$html .= '</table>';


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