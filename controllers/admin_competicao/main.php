<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$custa = new Custa();
$grupo = new GrupoCusta();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Competi��es
                        <small>Lista de Competi��es</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="#"><i class="fa fa-trophy"> </i> Competi��es</a></li>
                                         <li class="active">Lista de Competi��es</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/competicao/lista.html");

  
 $TPL->checked_ativo = "checked='checked'";
 $TPL->LOADING = CARREGANDO;
 $TPL->block("BLOCK_PESQUISAR");


$TPL->show();
?>