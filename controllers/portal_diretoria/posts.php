<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/diretoria/posts.html");
$obj = new Post();
$objDir = new Diretoria();
$idDiretoria = $obj->md5_decrypt($_REQUEST['id']);
$objDir->getById($idDiretoria);
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1; 
$TPL->CATEGORIA = $idDiretoria;          
$TPL->ANO = $ano;
$TPL->TITULO = $objDir->descricao;
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>