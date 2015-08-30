<?php
$menu = 20; 
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Página
			                            <small>Edita Links</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><i class="fa fa-file"> </i> Links</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$pagina = new Pagina();
$pagina->getById(Pagina::LINKS);
$TPL->addFile("CONTEUDO", "templates/admin/pagina/edit.html");
$TPL->LABEL = "Diretoria";
$TPL->texto = $pagina->conteudo;
$TPL->ACAO = "editar";
$TPL->id = $pagina->id;
$TPL->show();
?>