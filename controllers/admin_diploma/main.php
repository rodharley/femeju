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
                        Diploma
                        <small>Lista de Diplomas</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_perfil-main"><i class="fa fa-file-text"> </i> Diplomas</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/diploma/pesquisa.html");
$rs = $obj->getDiplomas();
foreach ($rs as $key => $value) {
	$TPL->titulo = $value->titulo;
	$TPL->ID_HASH = $obj->md5_encrypt($value->id);
	$TPL->block("BLOCK_DIPLOMA");
}
$TPL->show();
?>