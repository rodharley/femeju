<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usu�rios
			                            <small>Lista de Usu�rios</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
			                            <li><a href="admin_perfil-main"><i class="fa fa-user"> </i> Usu�rio</a></li>
			                             <li class="active">Listar</li>
			                        </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/usuario/main.html");
$TPL->LOADING = CARREGANDO;
$TPL->ID_PERFIL_RESPONSAVEL = Perfil::RESPONSAVEL;
$rsPerfil = $perfil->getRows();
foreach ($rsPerfil as $key => $value) {
   
   if($value->id != Perfil::RESPONSAVEL){
    $TPL->ID_PERFIL = $value->id;
    $TPL->DESC_PERFIL = $value->descricao;    
    $TPL->block("ITEM_PERFIL");
   }
}


$TPL->show();
?>