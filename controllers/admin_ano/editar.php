<?php
$menu = 38;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Anuidade
                        <small>Lista de Anos</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade-main"><i class="fa fa-trophy"> </i> Anuidades</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

$objAno = new Ano();
$TPL->addFile("CONTEUDO", "templates/admin/ano/edit.html");
$TPL->ACAO = "incluir";
if(isset($_REQUEST['id'])){
    $objAno->getById($objAno->md5_decrypt($_REQUEST['id']));
    $TPL->ANO = $objAno->anoReferencia;
    $TPL->DATA_VENCIMENTO = $objAno->convdata($objAno->dataVencimento,"mtn");
    $TPL->ID = $objAno->id;
    $TPL->ACAO = 'editar';
}
$TPL->show();
?>