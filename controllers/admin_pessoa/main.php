<?php
$menu = 42;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pessoas
                        <small>Lista de Pessoas</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pessoa-main"><i class="fa fa-child"> </i> Pessoas</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/pessoa/pesquisa.html");
$TPL->LOADING = CARREGANDO;
$TPL->show();
?>