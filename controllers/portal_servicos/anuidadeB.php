<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objAn = new Ano();
$objAssociacao = new Associacao();
$objA = new Atleta();
$objC = new Custa();
$objAn = new Anuidade();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/anuidade/anuidadeB.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['idAssociacaoHash']));
$objC->getById(Custa::ANUIDADE_PADRAO);
$TPL->NOME_ASSOCIACAO = $objAssociacao->nome;
$TPL->LOGO_ASSOCIACAO = $objAssociacao->logomarca;
$TPL->LABEL = "Anuidade";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ANO = $_REQUEST['ano'];

if(isset($_REQUEST['todos']))
$rsAtletas = $objA->listaPorAssociacaoInativo($objAssociacao->id);
else
$rsAtletas = $objA->listaPorArrayIds($_REQUEST['atleta']);
$totalValor = 0;
foreach ($rsAtletas as $key => $value) {
    $TPL->ATLETA = $value->pessoa->getNomeCompleto();
    $TPL->ID_ATLETA = $value->id;
    //custas
       
            $TPL->ID_CUSTA = $objC->id;
            $TPL->LABEL_CUSTA = $objC->titulo;
            $TPL->VALOR_CUSTA = $objC->money($objC->valor,"atb");
            $totalValor += $objC->valor;
    
    $TPL->block("BLOCK_ATLETAS");
}
$TPL->VALOR_TOTAL_CUSTA = $objC->money($totalValor,"atb");
//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows();
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
} 

$TPL->show();
?>