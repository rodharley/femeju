<?php
$menu = 25;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$objAssociacao = new Associacao();
$uf = new Uf();
$cidade = new Cidade();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Associa��o
                        <small>Edi��o de Associa��o</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_associacao-main"><i class="fa fa-users"> </i> Associa��es</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/associacao/edit.html");


$TPL->LABEL = "Nova Associa��o";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->LOGOMARCA = "";
$selectedUf = 0;
$selectedCidade = 0;
$TPL->checkedAtivo = "checked";
$TPL->checkedInativo = "";
$listaUf = $uf->getRows();
if(isset($_REQUEST['id'])){
	$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['id']));
	$TPL->nome = $objAssociacao->nome;
    $TPL->razaoSocial = $objAssociacao->razaoSocial;
	$TPL->descricao = $objAssociacao->descricao;
    $TPL->sigla = $objAssociacao->sigla;
    $TPL->cnpj = $objAssociacao->cnpj;
    if($objAssociacao->dataFiliacao != null)
        $TPL->dataFiliacao = $objAssociacao->convdata($objAssociacao->dataFiliacao,"mtn");
	$TPL->endereco = $objAssociacao->endereco;
    $TPL->bairro = $objAssociacao->bairro;
    if($objAssociacao->cidade != null){
         $selectedUf   = $objAssociacao->cidade->uf->id;
        $selectedCidade = $objAssociacao->cidade->id;
        $listaCidade = $cidade->getRows(0,9999,array("nome"=>"ASC"),array("uf"=>"=".$objAssociacao->cidade->uf->id));
        foreach ($listaCidade as $key => $value) {
                 $TPL->selectedCidade = "";
                  $TPL->nome_cidade = $value->nome;
                  $TPL->id_cidade = $value->id;
                  if($selectedCidade == $value->id)
                    $TPL->selectedCidade = "selected";
                  $TPL->block("BLOCK_CIDADE");
              }     
    }
    $TPL->cep = $objAssociacao->cep;    
    $TPL->telefone1 = $objAssociacao->telefone1;
    $TPL->telefone2 = $objAssociacao->telefone2;
    $TPL->email = $objAssociacao->email;
    $TPL->website = $objAssociacao->webSite;
    $TPL->midiaSocial = $objAssociacao->midiaSocial;
	$TPL->id = $objAssociacao->id;
    $TPL->id_responsavel = $objAssociacao->responsavel->pessoa->id;
    $TPL->nome_responsavel = $objAssociacao->responsavel->pessoa->nome;
    $TPL->sobrenome_responsavel = $objAssociacao->responsavel->pessoa->sobrenome;
    $TPL->email_responsavel = $objAssociacao->responsavel->pessoa->email;
    $TPL->celular_responsavel = $objAssociacao->responsavel->pessoa->telCelular;
    
	$TPL->LOGOMARCA = "img/associacoes/".$objAssociacao->logomarca;
	$TPL->LABEL = "Alterar Associa��o ".$objAssociacao->nome;
	$TPL->ACAO = "editar";
	if(strlen($objAssociacao->logomarca) > 0){
		$TPL->LOGOMARCA = "<img src='img/associacoes/".$objAssociacao->logomarca."' class='file-preview-image' alt='".$objAssociacao->logomarca."' title='".$objAssociacao->logomarca."'>";
		$TPL->block("BLOCK_IMG");
	}
    
    foreach ($objAssociacao->fotos as $key => $foto) {
        $TPL->FOTOS = "<img src='img/associacoes/".$foto->imagem."' class='file-preview-image' alt='".$foto->imagem."' title='".$foto->imagem."'><br/><button value='".$foto->id."' class='btn btn-default btExcluirImagem' type='button'><i class='glyphicon glyphicon-ban-circle'></i> Apagar</button>";
        $TPL->block("BLOCK_FOTOS");
    }   
	
}

 foreach ($listaUf as $key => $value) {
     $TPL->selectedUf = "";
      $TPL->uf = $value->uf;
      $TPL->id_uf = $value->id;
      if($selectedUf == $value->id)
        $TPL->selectedUf = "selected";
      $TPL->block("BLOCK_UF");
  }     
$TPL->show();
?>