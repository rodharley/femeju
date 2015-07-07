<?php
$menu = 6;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$post = new Post();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                                    <h1>
                                        Calendário
                                        <small>Pesquisa</small>
                                    </h1>
                                    <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
                                        <li><a href="admin_noticia-main"><i class="fa fa-calendar"> </i> Calendário</a></li>
                                        <li class="active">Pesquisa</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/post/pesquisa.html");

$TPL->NOME_CATEGORIA = "Calendário";
$TPL->ID_CATEGORIA = Categoria::CALENDARIO;
$TPL->URL_CATEGORIA = "calendario";

$TPL->show();