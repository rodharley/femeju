<?php
$menu = 45;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$grad = new Ano();

include("includes/include.mensagem.php");

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Relat�rios
                        <small>Eventos e Competi��es</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade-main"><i class="fa fa-trophy"> </i> Relat�rios</a></li>
                                         <li class="active">Eventos e Competi��es</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/relatorios/competicao_lista.html");
$TPL->show();
?>