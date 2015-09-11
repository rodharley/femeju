<?php
$objCat = new Categoria(Categoria::FAIXA_PRETA);
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/post/main.html");
$obj = new Post();
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : Date("Y");
$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1; 
$TPL->CATEGORIA = $objCat->id;          
$TPL->ANO = $ano;
$TPL->TITULO = $objCat->retornaDescricao($objCat->id);
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>