<?php
$menu = 36;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Classe
                        <small>Edição de classes</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_classe-main"><i class="fa fa-trophy"> </i> Classe</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/classe/edit.html");
$obj = new Classe();

$TPL->LABEL = "Incluir Classe";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->ativosim = "checked";
$TPL->ativonao = ""; 
$TPL->MIN = "20";
$TPL->MAX = "35";

if(isset($_REQUEST['id'])){
    $TPL->LABEL = "Editar Classe";
    $TPL->ACAO = "editar";    
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
	$TPL->id = $obj->id;
    $TPL->descricao = $obj->descricao;
   
	$TPL->ativosim = $obj->ativo ? "checked" : "";
	$TPL->ativonao = !$obj->ativo ? "checked" : "";
    $TPL->MIN = $obj->minimo;
    $TPL->MAX = $obj->maximo;
     
  
}

$TPL->show();
?>