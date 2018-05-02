<?php
$menu = 49;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");



include("includes/include.mensagem.php");

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Relatórios
                        <small>Arquivo do BRB</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_relatorios"><i class="fa fa-money"> </i> Pagamentos</a></li>
                                         <li><a href="admin_relatorios-despesas">Relatórios</a></li>
                                         <li class="active">Arquivo BRB</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/relatorios/arquivo_brb.html");
$date = new DateTime(date("Y-m-d"));
$TPL->DATAI = $date->format("d/m/Y");
$interval = new DateInterval('P1M');
$date->add($interval);
$TPL->DATAF =$date->format("d/m/Y");
$TPL->show();
?>