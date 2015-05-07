<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/noticia/main.html");
$obj = new Noticia();
$TPL->BREADCRUMB = '<ol class="breadcrumb">
                                <li>
                                    <a href="portal_home-index">Home</a>
                                </li>
                                <li class="active">
                                    <a href="#">Notícias</a>
                                </li>
                            </ol>';
$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1;                            
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>