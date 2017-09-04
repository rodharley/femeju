<?php
$menu = 48;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Despesa
                        <small>Registrar Despesa</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-money"> </i> Despesas</a></li>
                                         <li class="active">Registrar Despesa</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/despesa/lancar.html");

$TPL->show();
?>