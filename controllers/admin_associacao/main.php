<?php
$menu = 25;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Associação
                        <small>Lista de Associações</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_associacao-main"><i class="fa fa-users"> </i> Associações</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/associacao/pesquisa.html");
$TPL->LOADING = CARREGANDO;
$TPL->show();
?>