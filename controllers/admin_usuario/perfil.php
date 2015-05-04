<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Selecione o Perfil</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li class="active">Perfil</li>
			                        </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/usuario/perfil.html");
if($_SESSION['grc.userPerfilId'] > 0)
$rsPerfil = $perfil->getRows(0,999,array(),array("id"=>" >= ".$_SESSION['grc.userPerfilId']));
else
$rsPerfil = $perfil->getRows(0,999,array("id"=>"asc"),array());
 foreach($rsPerfil as $key => $p){
	$TPL->ID_PERFIL_HASH = $perfil->md5_encrypt($p->id);
	$TPL->labelItem = $p->descricao;
	$TPL->block("BLOCK_ITEM_LISTA");

}
$TPL->show();
?>