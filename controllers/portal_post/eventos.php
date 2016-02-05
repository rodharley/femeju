<?php
$objCat = new Categoria(Categoria::COMPETICOES);
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/post/main.html");
$obj = new Post();
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : Date("Y");
$TPL->LOADING = CARREGANDO;
$TPL->PAGINA = 1; 
$TPL->CATEGORIA = $objCat->id;          
$TPL->ANO = $ano;
$TPL->TITULO = $objCat->retornaDescricao($objCat->id);
$TPL->ICONE = $objCat->retornaPasta($objCat->id);
$TPL->BOTOES = "<a class='btn btn-success' href='portal_servicos-inscricoes'/>Inscrições Abertas</a>";
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>