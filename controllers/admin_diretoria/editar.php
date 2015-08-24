<?php
$menu = 4;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Diretoria
                        <small>Edição de Diretoria</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="Diretoria-listar"><i class="fa fa-home"> </i> Diretorias</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/diretoria/edit.html");
$obj = new Diretoria();
$objU = new Usuario();
$idResp = 0;
$rsUsers = $objU->listarUsuarios(0,999,"");
$TPL->LABEL = "Incluir Diretoria";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$arrayMenusSelecionados = array();


if(isset($_REQUEST['id'])){
    $TPL->LABEL = "Editar Diretoria";
    $TPL->ACAO = "editar";
    $TPL->id = $_REQUEST['id'];
    $obj->getById($obj->md5_decrypt($_REQUEST['id']));
    $TPL->nome = $obj->descricao; 
    $idResp = $obj->usuario->id;   
    
}
foreach ($rsUsers as $key => $value) {
	if($value->ativo == 1){    
	$TPL->NOME_RESP= $value->pessoa->nome;
    $TPL->ID_RESP = $value->id;
    if($idResp == $value->id)
        $TPL->SELECTED = "selected='selected'";
    $TPL->block("BLOCK_RESP");
    }
    $TPL->SELECTED = "";
    
}

$TPL->show();
?>