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
                        <small>Edição de Atleta</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_atleta-main"><i class="fa fa-child"> </i> Atletas</a></li>
                                         <li class="active">Editar</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/atleta/visualizar.html");


$TPL->LABEL = "Visualizar Atleta";
$TPL->FOTO = "";
$TPL->CHECKED_ATLETA = "";
$TPL->CHECKED_TECNICO = "";
$TPL->CHECKED_ARBITRO = "";
if(isset($_REQUEST['id'])){
     
    $objAtleta->getById($objAtleta->md5_decrypt($_REQUEST['id']));    
    $TPL->NOME = $objAtleta->pessoa->nome;
    $TPL->NOME_MEIO = $objAtleta->pessoa->nomeMeio;
    $TPL->SOBRE_NOME = $objAtleta->pessoa->sobrenome;
    $TPL->ATIVO = $objAtleta->ativo ? "Regular" : "Irregular";
    $TPL->CHECKED_ATLETA = $objAtleta->bitAtleta ? "Atleta" : "";
	$TPL->CHECKED_TECNICO = $objAtleta->bitTecnico ? "Técnico" : "";	
	$TPL->CHECKED_ARBITRO = $objAtleta->bitArbitro ? "Árbitro" : ""; 
    $TPL->NUMERO_FEMEJU = $objAtleta->getId();
	if($objAtleta->pessoa->bitVerificado)
	$TPL->VERIFICADO  = "Sim";
	$TPL->NACIONALIDADE = $objAtleta->pessoa->nacionalidade;
    $TPL->EMAIL = $objAtleta->pessoa->email;
    $TPL->DATA_NASCIMENTO = $objAtleta->convdata($objAtleta->pessoa->dataNascimento,"mtn");
    $TPL->SEXO = $objAtleta->pessoa->sexo == "F" ? "Feminino" : "Masculino";    
    $TPL->CPF = strlen($objAtleta->pessoa->cpf) >= 11 ? $objAtleta->pessoa->cpf : "";
    $TPL->TELEFONE_RES = $objAtleta->pessoa->telResidencial;
    $TPL->TELEFONE_CEL = $objAtleta->pessoa->telCelular;
    $TPL->ENDERECO = $objAtleta->pessoa->endereco;
    $TPL->BAIRRO = $objAtleta->pessoa->bairro;
    $TPL->CEP = $objAtleta->pessoa->cep;
    $TPL->REGISTRO_CONF = $objAtleta->registroConfederacao;
    $TPL->DATA_FILIACAO = $objAtleta->convdata($objAtleta->dataFiliacao,"mtn");
    $TPL->DATA_EMISSAO_CART = $objAtleta->convdata($objAtleta->dataEmissaoCarteira,"mtn");        
    $TPL->FILIACAO_PAI  = $objAtleta->pessoa->filiacaoPai;
    $TPL->FILIACAO_MAE  = $objAtleta->pessoa->filiacaoMae;
    $TPL->TELEFONE_COM = $objAtleta->pessoa->telComercial;
	$TPL->WEB_SITE =  $objAtleta->pessoa->webSite;
	$TPL->MIDIA_SOCIAL =  $objAtleta->pessoa->midiaSocial;
	$TPL->VACINAS = $objAtleta->pessoa->vacinas;
    $TPL->OBS = $objAtleta->observacoes;
	$TPL->RG = $objAtleta->pessoa->rg;
	$TPL->RG_ORGAO_EXP = $objAtleta->pessoa->rgOrgaoExpedidor;
	$TPL->RG_DATA_EXP = $objAtleta->convdata($objAtleta->pessoa->rgDataExp,"mtn");
	$TPL->PASSAPORTE = $objAtleta->pessoa->passaporte;
	$TPL->PASSAPORTE_VAL = $objAtleta->convdata($objAtleta->pessoa->passaporteDataVal,"mtn");
	$TPL->PASSAPORTE_ORGAO_EXP = $objAtleta->pessoa->passaporteOrgao;
	$TPL->PASSAPORTE_DATA_EXP = $objAtleta->convdata($objAtleta->pessoa->passaporteDataExp,"mtn");
    $TPL->nome_uf_nat = $objAtleta->pessoa->naturalidade != null ? $objAtleta->pessoa->naturalidade->uf->nome : "";
    $TPL->nome_cidade_nat = $objAtleta->pessoa->naturalidade != null ? $objAtleta->pessoa->naturalidade->nome : "";
    $TPL->nome_uf = $objAtleta->pessoa->cidade != null ? $objAtleta->pessoa->cidade->uf->nome: "";    
    $TPL->nome_cidade = $objAtleta->pessoa->cidade != null ? $objAtleta->pessoa->cidade->nome : "";
    $TPL->associacao = $objAtleta->associacao != null ? $objAtleta->associacao->nome : "";
    //historico da graduacao
    $hist = new HistoricoGraduacao();
    $historico = $hist->getUltimo($objAtleta->id);
    $TPL->DATA_GRADUACAO = $hist->convdata($historico->data,"mtn");    
     $TPL->BELT_COLOR_SELECTED = $objAtleta->graduacao != null ? $objAtleta->graduacao->imagem : "";        
     $TPL->BELT_NAME_SELECTED = $objAtleta->graduacao != null ? $objAtleta->graduacao->descricao : "";
    
    //foto
    if(strlen($objAtleta->pessoa->foto) > 0){
        $TPL->FOTO = "<img src='img/pessoas/".$objAtleta->pessoa->foto."' class='file-preview-image' alt='".$objAtleta->pessoa->foto."' title='".$objAtleta->pessoa->foto."'>";
    }
 		
}
   
$TPL->show();
?>