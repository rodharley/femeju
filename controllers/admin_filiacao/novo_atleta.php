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
			                            Filiação
			                            <small>Cadastro de novo Atleta</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                        <li><a href="admin_home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
                                        <li><a href="admin_noticia-main"><i class="fa fa-pencil"> </i> Filiação</a></li>
			                            <li class="active">Novo Atleta</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/filiacao/novo.html");




$TPL->show();
?>