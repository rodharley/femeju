<?php
$menu = 0;
//include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Painel de Controle
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
                        <li class="active">Painel de Controle</li>
                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/home/home.html");

$TPL->show();
?>
