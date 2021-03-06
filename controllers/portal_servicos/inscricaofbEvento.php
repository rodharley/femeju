<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$objGrupoCompeticao = new GrupoCompeticao();
$objA = new Atleta();
$objConf = new Configuracoes();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaofb_evento.html");
$objAssociacao->getById($_REQUEST['idAssociacao']);
$objc->getById($_REQUEST['idCompeticao']);
$taxas = $objConf->recuperaConfiguracoesTaxa();
$TPL->TAXA_PP = $taxas[13];
$TPL->TAXA_GN = $taxas[12];
$TPL->LABEL = "Preencha as informações adicionais da inscrição e confirme";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
if($objc->percentDesconto > 0){
	$TPL->PERCENT = $objc->percentDesconto;
	$TPL->DATA_DESCONTO = $objc -> convdata($objc -> dataDesconto, "mtn");
	$TPL->block("BLOCK_DESCONTO");
}
$TPL->ESPECIAL = 0;
if(isset($_REQUEST['especial'])){
	$TPL->ESPECIAL = 1;
	$TPL->block("BLOCK_ESPECIAL");
}
if(isset($_REQUEST['todos']))
$rsAtletas = $objA->listaPorAssociacaoAtivos($objAssociacao->id);
else
$rsAtletas = $objA->listaPorArrayIds($_REQUEST['atleta']);
$TPL->VALOR_CUSTA = $objc->money($objc->custa->valor,"atb");



foreach ($rsAtletas as $key => $value) {
    if($value->graduacao != null){
    $TPL->ATLETA = $value->pessoa->getNomeCompleto();
    $TPL->ID_ATLETA = $value->id;
    $TPL->GRAD_ATLETA = $value->graduacao->id;    
    
    $TPL->block("BLOCK_ATLETAS");
    
    }
}

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows(0,10,array(),array("ativo"=>"=1"));
//$TPL->CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
    $TPL->CHECKED = "";
} 


$TPL->show();
?>