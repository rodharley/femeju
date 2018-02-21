<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

$usu = new Usuario();
$uf = new Uf();
$cidade = new Cidade();
//$lacademia = new Academia();
$perfil = new Perfil();
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Edita Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                             <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
			                            <li><a href="admin_usuario-main"><i class="fa fa-user"> </i> Usuários</a></li>
			                            <li class="active">Editar</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/usuario/edit.html");
$listaUf = $uf->getRows();

$TPL->LABEL = "Novo Usuário";
$TPL->ACAO = "incluir";
$TPL->id = 0;
$TPL->checksim = "checked='checked'";
$TPL->checknao = "";
$TPL->IMG_USER = "img/pessoas/pessoa.png";
$selectedUf = 0;
$selectedCidade = 0;
$idPerfilUsu = 0;
$listaAcademias = array();
if(isset($_REQUEST['id'])){
	$usu->getById($usu->md5_decrypt($_REQUEST['id']));    
	$TPL->cpf = $usu->pessoa->cpf;
	$TPL->nome = $usu->pessoa->nome;
    $TPL->nomeMeio = $usu->pessoa->nomeMeio;
    $TPL->sobreNome = $usu->pessoa->sobrenome;
	$TPL->email = $usu->pessoa->email;
	$TPL->telefone = $usu->pessoa->telResidencial;
	$TPL->celular = $usu->pessoa->telCelular;
	$TPL->senha = "";
	$TPL->id = $usu->id;
	$TPL->ENDERECO = $usu->pessoa->endereco;
    $TPL->BAIRRO = $usu->pessoa->bairro;
    $TPL->CEP = $usu->pessoa->cep;
	$idPerfilUsu = $usu->perfil->id;
	$TPL->IMG_USER = "img/pessoas/".$usu->pessoa->foto;
	$TPL->LABEL = "Alterar Usuário ".$usu->pessoa->nome;
	$TPL->ACAO = "editar";
    $selectedUf = $usu->pessoa->cidade != null ? $usu->pessoa->cidade->uf->id: 0;
    $selectedCidade = $usu->pessoa->cidade != null ? $usu->pessoa->cidade->id : 0;
	if($usu->ativo == "0"){
	$TPL->checknao = "checked='checked'";
	$TPL->checksim = "";
	}
	if($usu->responsavel == 1){
	$TPL->ISRESPONSAVEL = "checked='checked'";		
	}

	if(strlen($usu->pessoa->foto) > 0){
		$TPL->IMG_USER = "<img src='img/pessoas/".$usu->pessoa->foto."' class='file-preview-image' alt='".$usu->pessoa->foto."' title='".$usu->pessoa->foto."'>";
		$TPL->block("BLOCK_IMG");
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
    
    
	$TPL->block("BLOCK_EDIT");
}else{
    $TPL->block("BLOCK_NOVO_USUARIO");
}

$rsPerfil = $perfil->getRows(0,999,array("id"=>"asc"),array());
 foreach($rsPerfil as $key => $p){
 	$TPL->idItem = $p->id;
	$TPL->labelItem = $p->descricao;
	if($p->id == $idPerfilUsu)
		$TPL->checkItem = "selected";
	else
		$TPL->checkItem = "";
	$TPL->block("BLOCK_ITEM");
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