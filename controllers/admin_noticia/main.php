<?php
$menu = 1;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$usu = new Noticia();

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Not�cias
			                            <small>Pesquisa</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_noticia-main"><i class="fa fa-dashboard"> </i> Not�cias</a></li>
			                            <li class="active">Pesquisa</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/noticia/pesquisa.html");




$TPL->show();
?>