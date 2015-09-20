<?php
$menu = 28;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$objAtleta = new Atleta();
$uf = new Uf();
$cidade = new Cidade();
$objAssociacao = new Associacao();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Atletas
                        <small>Edição de Atleta</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_atleta-main"><i class="fa fa-child"> </i> Atletas</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/atleta/edit.html");


$TPL->LABEL = "Novo Atleta";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->FOTO = "";
$selectedUf = 0;
$selectedCidade = 0;
$selectedAs = 0;
$TPL->checkedAtivo = "checked";
$TPL->checkedInativo = "";
$listaUf = $uf->getRows();
$listaAssociacao = $objAssociacao->listaAtivas();
if(isset($_REQUEST['id'])){
	
	
}

 foreach ($listaUf as $key => $value) {
     $TPL->selectedUf = "";
      $TPL->uf = $value->uf;
      $TPL->id_uf = $value->id;
      if($selectedUf == $value->id)
        $TPL->selectedUf = "selected";
      $TPL->block("BLOCK_UF");
  }    
 
 foreach ($listaAssociacao as $key => $value) {
     $TPL->SELECTED_AS = "";
      $TPL->DESC_AS = $value->nome;
      $TPL->ID_AS = $value->id;
      if($selectedAs == $value->id)
        $TPL->SELECTED_AS = "selected";
      $TPL->block("BLOCK_AS");
  }     
$TPL->show();
?>