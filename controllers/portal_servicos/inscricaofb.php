<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$objGrupoCompeticao = new GrupoCompeticao();
$objA = new Atleta();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaofb.html");
$objAssociacao->getById($_REQUEST['idAssociacao']);
$objc->getById($_REQUEST['idCompeticao']);

$TPL->LABEL = "Preencha as informaчѕes adicionais da inscriчуo e confirme";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
if(isset($_REQUEST['todos']))
$rsAtletas = $objA->listaPorAssociacaoAtivos($objAssociacao->id);
else
$rsAtletas = $objA->listaPorArrayIds($_REQUEST['atleta']);
$rsClasses = $objc->listaClasses();
$TPL->DOBRA1 = $objc->dobra1;
$TPL->DOBRA2 = $objc->dobra2;
$TPL->DOBRA3 = $objc->dobra3;
$TPL->VALOR_CUSTA = $objc->custa->valor;

//classes
       foreach ($rsClasses as $key2 => $grupo) {
            $TPL->ID_CLA = $grupo->classe->id;
            $TPL->LABEL_CLA = $grupo->classe->descricao;
            $TPL->block("BLOCK_CLA");
        }

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
$rspag = $objTP->getRows();
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
} 


$TPL->show();
?>