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
$objGrad = new Graduacao;
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Atletas
                        <small>Edi��o de Atleta</small>
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
$selectedUfNat = 0;
$selectedCidade = 0;
$selectedGrad = 0;
$selectedCidadeNaturalidade = 0;
$selectedAs = 0;
$TPL->CHECKED_ATIVO = "checked";
$TPL->CHECKED_INATIVO = "";
$listaUf = $uf->getRows();
$listaGrad = $objGrad->getRows();
$listaAssociacao = $objAssociacao->listaAtivas();
if(isset($_REQUEST['id'])){    
    $objAtleta->getById($objAtleta->md5_decrypt($_REQUEST['id']));    
    $TPL->LABEL = "Alterar Atleta";
    $TPL->ACAO = "editar";
    $TPL->id = $objAtleta->id;
    $TPL->ID_PESSOA = $objAtleta->pessoa->id;
    $TPL->NOME = $objAtleta->pessoa->nome;
    $TPL->SOBRE_NOME = $objAtleta->pessoa->sobrenome;
    $TPL->CHECKED_ATIVO = $objAtleta->ativo ? "checked" : "";
    $TPL->CHECKED_INATIVO = !$objAtleta->ativo ? "checked" : "";
    $TPL->NACIONALIDADE = $objAtleta->pessoa->nacionalidade;
    $TPL->EMAIL = $objAtleta->pessoa->email;
    $TPL->DATA_NASCIMENTO = $objAtleta->convdata($objAtleta->pessoa->dataNascimento,"mtn");
    $TPL->SELECTED_FEMININO = $objAtleta->pessoa->sexo == "F" ? "selected" : "";
    $TPL->SELECTED_MASCULINO = $objAtleta->pessoa->sexo == "M" ? "selected" : "";
    $TPL->CPF = $objAtleta->pessoa->cpf;
    $TPL->TELEFONE_RES = $objAtleta->pessoa->telResidencial;
    $TPL->TELEFONE_CEL = $objAtleta->pessoa->telCelular;
    $TPL->ENDERECO = $objAtleta->pessoa->endereco;
    $TPL->BAIRRO = $objAtleta->pessoa->bairro;
    $TPL->CEP = $objAtleta->pessoa->cep;
    $TPL->REGISTRO_CONF = $objAtleta->registroConfederacao;
    $TPL->DATA_FILIACAO = $objAtleta->convdata($objAtleta->dataFiliacao,"mtn");
    $TPL->DATA_EMISSAO_CART = $objAtleta->convdata($objAtleta->dataEmissaoCarteira,"mtn");        
    $selectedUfNat = $objAtleta->pessoa->naturalidade != null ? $objAtleta->pessoa->naturalidade->uf->id:0;
    $selectedUf = $objAtleta->pessoa->cidade != null ? $objAtleta->pessoa->cidade->uf->id: 0;    
    $selectedGrad = $objAtleta->graduacao != null ? $objAtleta->graduacao->id : 0; 
    $selectedAs = $objAtleta->associacao != null ? $objAtleta->associacao->id : 0;
    $selectedCidade = $objAtleta->pessoa->cidade != null ? $objAtleta->pessoa->cidade->id : 0;
    $selectedCidadeNaturalidade = $objAtleta->pessoa->naturalidade != null ? $objAtleta->pessoa->naturalidade->id : 0;
    $TPL->GRADUACAO = $selectedGrad;
    //foto
    if(strlen($objAtleta->pessoa->foto) > 0){
        $TPL->FOTO = "<img src='img/pessoas/".$objAtleta->pessoa->foto."' class='file-preview-image' alt='".$objAtleta->pessoa->foto."' title='".$objAtleta->pessoa->foto."'>";
        $TPL->block("BLOCK_FOTO");
    }
    //loop de cidade naturalidade
    $listaCidade = $cidade->getRows(0,9999,array("nome"=>"ASC"),array("uf"=>"=".$selectedUfNat));
        foreach ($listaCidade as $key => $value) {
                 $TPL->selectedCidadeNaturalidade = "";
                  $TPL->nome_cidade_nat = $value->nome;
                  $TPL->id_cidade_nat = $value->id;
                  if($selectedCidadeNaturalidade == $value->id)
                    $TPL->selectedCidadeNaturalidade = "selected";
                  $TPL->block("BLOCK_CIDADE_NATURALIDADE");
              }
	//loop de cidade endereco
    $listaCidade = $cidade->getRows(0,9999,array("nome"=>"ASC"),array("uf"=>"=".$selectedUf));
        foreach ($listaCidade as $key => $value) {
                 $TPL->selectedCidade = "";
                  $TPL->nome_cidade = $value->nome;
                  $TPL->id_cidade = $value->id;
                  if($selectedCidade == $value->id)
                    $TPL->selectedCidade = "selected";
                  $TPL->block("BLOCK_CIDADE");
              }
}ELSE{
    $TPL->block("BLOCK_NOVO_ATLETA2");
    $TPL->block("BLOCK_NOVO_ATLETA");
}



foreach ($listaGrad as $key => $value) {
    $TPL->BELT_COLOR = $value->imagem;
    if($selectedGrad == $value->id){
        $TPL->BELT_BTN = "primary";
        $TPL->BELT_IMG = "belt_icon_select.png";
    }else{
        $TPL->BELT_BTN = "default";
        $TPL->BELT_IMG = "belt_icon.png";
    }
    $TPL->BELT_NAME = $value->descricao;
    $TPL->BELT_ID = $value->id;
	$TPL->block("BLOCK_BELT");
}
 foreach ($listaUf as $key => $value) {
     $TPL->selectedUf = "";
     $TPL->selectedUf_nat = "";
      $TPL->uf = $value->uf;
      $TPL->id_uf = $value->id;
      if($selectedUf == $value->id)
        $TPL->selectedUf = "selected";
      if($selectedUfNat == $value->id)
        $TPL->selectedUf_nat = "selected";
      $TPL->block("BLOCK_UF");
      $TPL->block("BLOCK_UF_NATURALIDADE");
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