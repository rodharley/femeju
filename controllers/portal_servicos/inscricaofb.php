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


foreach ($rsAtletas as $key => $value) {
    if($value->graduacao != null){
    $TPL->ATLETA = $value->pessoa->getNomeCompleto();
    $TPL->ID_ATLETA = $value->id;
    $TPL->GRAD_ATLETA = $value->graduacao->id;
    $rsCategorias = $objGrupoCompeticao->listar($objc->id,$value->graduacao->id);
    //categorias
       foreach ($rsCategorias as $key2 => $grupo) {
            $TPL->ID_CAT = $grupo->categoria->id;
            $TPL->LABEL_CAT = $grupo->categoria->descricao;
            $TPL->block("BLOCK_CAT");
        }
    
    $TPL->block("BLOCK_ATLETAS");
    
    }
}

$TPL->show();
?>