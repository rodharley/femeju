<?php
$menu = 26;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$obj = new Configuracoes();
$uf = new Uf();
$cidade = new Cidade();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Configurações
                        <small>Editar</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_configuracoes-main"><i class="fa fa-gear"> </i> Configurações</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/configuracoes/edit.html");
$rs = $obj->getRows();
$TPL->ASSINATURA = "";
foreach ($rs as $key => $value) {
    $TPL->VALOR_CONF = $value->valor;
    $TPL->DESC_CONF = $value->descricao;
    $TPL->ID_CONF = $value->id;
	if($value->id ==  10 || $value->id ==  18){
		$TPL->block("BLOCK_ITEM_CONF_COLOR");
	}elseif($value->id == 11){
		if(strlen($value->valor) > 0){
		$TPL->ASSINATURA = "<img src='img/".$value->valor."' class='file-preview-image' alt='".$value->valor."' title='".$value->valor."'>";
		
		$TPL->block("BLOCK_IMG");
		}
		$TPL->block("BLOCK_ITEM_CONF_UPLOAD");
	}else{
		$TPL->block("BLOCK_ITEM_CONF");
	}
}
   
$TPL->show();
?>