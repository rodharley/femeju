<?php
$menu = 0;
include("includes/include.lock.php");
$TPL = NEW Template("templates/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Edita Dados do Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li class="active">Editar Meus dados</li>
			                        </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/usuario/meusdados.html");
$usu = new Usuario();

$TPL->LABEL = "Editar Meus dados";
$TPL->ACAO = "meusDados";
$TPL->IMG_USER = "img/avatar.png";
$TPL->idUser = $_SESSION['grc.userId'];
	$usu->getById($_SESSION['grc.userId']);
	$TPL->cpf = $usu->cpf;
	$TPL->nome = $usu->nome;
	$TPL->email = $usu->email;
	$TPL->login = $usu->login;
	$TPL->telefone = $usu->telefone;
	$TPL->celular = $usu->celular;
	$TPL->senha = "";
	
    if(strlen($usu->assinatura) > 0){
        $TPL->ASS_USER = "<img src='img/assinaturas/".$usu->assinatura."' class='file-preview-image' alt='".$usu->assinatura."' title='".$usu->assinatura."' width='140'>";
        $TPL->block("BLOCK_ASS");
    }

    if(strlen($usu->foto) > 0){
        $TPL->IMG_USER = "<img src='img/users/".$usu->foto."' class='file-preview-image' alt='".$usu->foto."' title='".$usu->foto."'>";
        $TPL->block("BLOCK_IMG");
    }

$TPL->show();
?>