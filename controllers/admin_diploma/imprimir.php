<?php
$menu = 52;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Diploma();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Diretoria
                        <small>Imprimir Diplomas</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_diploma"><i class="fa fa-file-text"> </i> Diplomas</a></li>
                                         <li class="active">Imprimir</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/diploma/imprimir.html");

$rs = $obj->getDiplomas();
foreach ($rs as $key => $value) {
	$TPL->id = $value->id;
	$TPL->titulo = $value->titulo;
	$TPL->block("BLOCK_DIPLOMA");
}
$TPL->show();
?>