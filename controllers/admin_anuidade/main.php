<?php
$menu = 31;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Anuidade</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade"><i class="fa fa-credit-card"> </i> Anuidade</a></li>
                                         <li class="active">Pesquisa Atleta</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/anuidade/pesquisa.html");
$TPL->LOADING = $obj->carregando;
$TPL->show();
?>