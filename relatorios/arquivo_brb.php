<?php
//iniciando acessгo
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
header('Content-Type: text/html; charset=utf-8');
header('Content-Disposition: attachment; filename="arquivo_brb.txt"');
//classes do frame work
require ("../class_arquitetura/biblioteca.php");
require ("../class_arquitetura/conexao.php");
require ("../class_arquitetura/persistencia.php");
require ("../class_modelo/classes.php");

$conn = Conexao::init();
$root = new Persistencia();
$oConf = new Configuracoes();
$oPag = new Pagamento();
$brb = $oConf->recuperaConfiguracoesBRB();
//recupera os pagamentos em aberto do perнodo:
$pagamentos = $oPag->pesquisarBoletosBrb($oPag->convdata($_REQUEST['datai'],"ntm"),$oPag->convdata($_REQUEST['dataf'],"ntm"));
$totalRegistros =  count($pagamentos)+1;
//cria o header
$arquivo = "DCB001077".$brb[12].date("YYmd").date("His").$totalRegistros."\r\n";

//loop nos pagamentos
foreach ($pagamentos as $key => $pagamento) {
	if(strlen($pagamento->codigo) > 0){
	$linha = "01";
	$linha .= substr($pagamento->codigo,4,3);
	$linha .=  str_pad($brb[12], 10, '0', STR_PAD_LEFT);
	$linha .=  $pagamento->codigo;
	$linha .=  str_pad($pagamento->id, 6, '0', STR_PAD_LEFT);
	$linha .=  str_pad($pagamento->nomeSacado, 45, ' ', STR_PAD_RIGHT);
	$linha .=  str_pad($pagamento->enderecoSacado, 60, ' ', STR_PAD_RIGHT);
	$linha .=  str_pad($pagamento->bairroSacado, 15, ' ', STR_PAD_RIGHT);
	$linha .=  str_pad($pagamento->cidadeSacado, 22, ' ', STR_PAD_RIGHT);
	$linha .=  str_pad($pagamento->ufSacado, 2, ' ', STR_PAD_RIGHT);
	$linha .=  "00000000";
	$linha .=  strlen($pagamento->cpfSacado) > 11 ? "2" :"1";
	$linha .=  str_pad($pagamento->cpfSacado, 14, ' ', STR_PAD_RIGHT);
	$linha .=  "    ";
	$linha .=  "0";
	$linha .=  "22";
	$linha .=  "02";
	$linha .=  "2";
	$linha .=  str_pad($brb[13], 4, '0', STR_PAD_LEFT);
	$linha .=  str_pad(date("dmY",$pagamento->dataEmissao), 8, ' ', STR_PAD_RIGHT);//data da emissao
	$linha .=  "0"; //codigo da condiзгo
	$linha .=  str_pad(str_replace("/", "",$oConf->convdata($pagamento->dataVencimento,"mtn")), 8, ' ', STR_PAD_RIGHT);
	$linha .=  str_pad(str_replace(".", "",$pagamento->valorTotal), 15, '0', STR_PAD_LEFT);//data de vencimento
	$linha .=  "0000000000";
	$linha .=  "0000000000";
	$linha .=  "0000000";
	$linha .=  "000";
	$linha .=  "00";
	$linha .=  "0000000000";
	$linha .=  "0";
	$linha .=  "0000000000";
	$linha .=  "00000000";
	$linha .=  "0000000000";
	$linha .=  "00000000";
	$linha .=  "0000000000";
	$linha .=  "00000000";
	$linha .=  "000000000000000000000000";
	$linha .=  "01";
	$linha .=  "0";
	$linha .=  "         ";

	$arquivo .= $linha."\r\n";
	}
}


echo $arquivo;
exit();
?>