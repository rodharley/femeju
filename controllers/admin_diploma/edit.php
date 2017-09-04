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
                        Diplomas
                        <small>Cadastrar Diploma</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_diploma"><i class="fa fa-file-text"> </i> Diplomas</a></li>
                                         <li class="active">Cadastrar Diploma</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/diploma/edit.html");
$TPL->ACAO = 'incluir';
if(isset($_REQUEST['id'])){
	$obj->getById($obj->md5_decrypt($_REQUEST['id']));
	$TPL->ACAO = 'editar';
	$TPL->titulo = $obj->titulo;
	$TPL->texto = $obj->layout;
	$TPL->id = $obj->id;
}
$TPL->show();
?>