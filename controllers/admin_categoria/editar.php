<?php
$menu = 36;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

if(!isset($_REQUEST['idClasse'])){
    $_SESSION['fmj.mensagem'] = 63;
    header("Location:admin_classe-main");
    exit();
}
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Categoria
                        <small>Edi��o de Categorias</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_categoria-main"><i class="fa fa-trophy"> </i> Categoria</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/categoria/edit.html");
$obj = new CategoriaPeso();
$objClasse = new Classe();

$objClasse->getById($obj->md5_decrypt($_REQUEST['idClasse']));

$TPL->CLASSE= $objClasse->descricao;
$TPL->ID_CLASSE = $objClasse->id;
$TPL->LABEL = "Incluir Categoria";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->ativosim = "checked";
$TPL->ativonao = ""; 
$TPL->checkfeminino = "checked";
$TPL->checkmasculino = "";
$TPL->MIN = "50";
$TPL->MAX = "58";

if(isset($_REQUEST['id'])){
    $TPL->LABEL = "Editar Categoria";
    $TPL->ACAO = "editar";    
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
	$TPL->id = $obj->id;
    $TPL->descricao = $obj->descricao;
   
	$TPL->ativosim = $obj->ativo ? "checked" : "";
	$TPL->ativonao = !$obj->ativo ? "checked" : "";
	$TPL->checkfeminino = $obj->genero == "F" ? "checked" : "";
	$TPL->checkmasculino = $obj->genero == "M" ? "checked" : "";
    $TPL->MIN = $obj->minimo;
    $TPL->MAX = $obj->maximo;
     
  
}

$TPL->show();
?>