<?php
$menu = 0;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Edita Dados do Usuário</small>
			                        </h1>
			                        <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_perfil-main"><i class="fa fa-user"> </i> Usuário</a></li>
                                         <li class="active">Meus Dados</li>
                                    </ol>
                </section>';

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/usuario/meusdados.html");
$usu = new Usuario();

$TPL->LABEL = "Editar Meus dados";
$TPL->ACAO = "meusDados";
$TPL->IMG_USER = "img/pessoa.png";
$TPL->idUser = $_SESSION['fmj.userId'];
	$usu->getById($_SESSION['fmj.userId']);
	$TPL->cpf = $usu->pessoa->cpf;
	$TPL->nome = $usu->pessoa->nome;
	$TPL->email = $usu->pessoa->email;
	$TPL->telefone = $usu->pessoa->telResidencial;
	$TPL->celular = $usu->pessoa->telCelular;
	$TPL->senha = "";
	
   
    if(strlen($usu->pessoa->foto) > 0){
        $TPL->IMG_USER = "<img src='img/pessoas/".$usu->pessoa->foto."' class='file-preview-image' alt='".$usu->pessoa->foto."' title='".$usu->pessoa->foto."'>";
        $TPL->block("BLOCK_IMG");
    }

$TPL->show();
?>