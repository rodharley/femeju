<?php
$menu = 42;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$objPessoa = new Pessoa();
$uf = new Uf();
$cidade = new Cidade();
$objAssociacao = new Associacao();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pessoas
                        <small>Edição de Pessoa</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pessoa-main"><i class="fa fa-child"> </i> Pessoas</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/pessoa/edit.html");


$TPL->LABEL = "Novo Pessoa";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->FOTO = "";
$selectedUf = 0;
$selectedUfNat = 0;
$selectedCidade = 0;
$selectedCidadeNaturalidade = 0;
$selectedAs = 0;
$listaUf = $uf->getRows();

if(isset($_REQUEST['id'])){
    $objPessoa->getById($objPessoa->md5_decrypt($_REQUEST['id']));    
    $TPL->LABEL = "Alterar Pessoa";
    $TPL->ACAO = "editar";
    $TPL->id = $objPessoa->id;    
    $TPL->NOME = $objPessoa->nome;
    $TPL->NOME_MEIO = $objPessoa->nomeMeio;
    $TPL->SOBRE_NOME = $objPessoa->sobrenome;
    //$TPL->SEMCPFCHECKED = strlen($objPessoa->cpf) < 11 ? "checked" : "";
    //$TPL->SEMRGCHECKED = $objPessoa->rg == "" ? "checked" : "";
	$TPL->NACIONALIDADE = $objPessoa->nacionalidade;
    $TPL->EMAIL = $objPessoa->email;
    $TPL->DATA_NASCIMENTO = $objPessoa->convdata($objPessoa->dataNascimento,"mtn");
    $TPL->SELECTED_FEMININO = $objPessoa->sexo == "F" ? "selected" : "";
    $TPL->SELECTED_MASCULINO = $objPessoa->sexo == "M" ? "selected" : "";
    $TPL->CPF = strlen($objPessoa->cpf) >= 11 ? $objPessoa->cpf : "";
    $TPL->TELEFONE_RES = $objPessoa->telResidencial;
    $TPL->TELEFONE_CEL = $objPessoa->telCelular;
    $TPL->ENDERECO = $objPessoa->endereco;
    $TPL->BAIRRO = $objPessoa->bairro;
    $TPL->CEP = $objPessoa->cep;
    $TPL->FILIACAO_PAI  = $objPessoa->filiacaoPai;
    $TPL->FILIACAO_MAE  = $objPessoa->filiacaoMae;
    $TPL->TELEFONE_COM = $objPessoa->telComercial;
	$TPL->WEB_SITE =  $objPessoa->webSite;
	$TPL->MIDIA_SOCIAL =  $objPessoa->midiaSocial;
	$TPL->VACINAS = $objPessoa->vacinas;
	$TPL->RG = $objPessoa->rg;
	$TPL->RG_ORGAO_EXP = $objPessoa->rgOrgaoExpedidor;
	$TPL->RG_DATA_EXP = $objPessoa->convdata($objPessoa->rgDataExp,"mtn");
	$TPL->PASSAPORTE = $objPessoa->passaporte;
	$TPL->PASSAPORTE_VAL = $objPessoa->convdata($objPessoa->passaporteDataVal,"mtn");
	$TPL->PASSAPORTE_ORGAO_EXP = $objPessoa->passaporteOrgao;
	$TPL->PASSAPORTE_DATA_EXP = $objPessoa->convdata($objPessoa->passaporteDataExp,"mtn");
    $selectedUfNat = $objPessoa->naturalidade != null ? $objPessoa->naturalidade->uf->id:0;
    $selectedUf = $objPessoa->cidade != null ? $objPessoa->cidade->uf->id: 0;    
    $selectedCidade = $objPessoa->cidade != null ? $objPessoa->cidade->id : 0;
    $selectedCidadeNaturalidade = $objPessoa->naturalidade != null ? $objPessoa->naturalidade->id : 0;
    
    //foto
    if(strlen($objPessoa->foto) > 0){
        $TPL->FOTO = "<img src='img/pessoas/".$objPessoa->foto."' class='file-preview-image' alt='".$objPessoa->foto."' title='".$objPessoa->foto."'>";
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
 
 
$TPL->show();
?>