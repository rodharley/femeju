<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/main.html");
include("includes/include.montaMenu.php");


//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();
$objEmpresa = new Empresa();


//verificar se perfil selecionado
if(!isset($_REQUEST['idPerfil'])){
	$_SESSION['grc.mensagem'] = 64;
	header("Location:usuario-perfil");
	exit();
}
$idPerfil = $usu->md5_decrypt($_REQUEST['idPerfil']);

if($_SESSION['grc.userPerfilId'] > 0){
if($idPerfil == "" || $idPerfil < $_SESSION['grc.userPerfilId']){
	$_SESSION['grc.mensagem'] = 7;
	header("Location:usuario-perfil");
	exit();
}
}

$maximo = 0;
if($_SESSION['grc.empresaId'] != 0){
$objEmpresa->getById($_SESSION['grc.empresaId']);
	if($idPerfil == Perfil::ENG_ADM)
		$maximo = $objEmpresa->qtdEngAdm;
	if($idPerfil == Perfil::ENG_MAN)
		$maximo = $objEmpresa->qtdEngMan;
}

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Lista de Usuários</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="home-home"><i class="fa fa-dashboard"> </i> Home</a></li>
			                            <li><a href="usuario-perfil"><i class="fa fa-users"> </i> Perfil</a></li>
			                             <li class="active">Listar</li>
			                        </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/usuario/list.html");
$TPL->LOADING = $usu->carregando;
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$TPL->PESQUISA = $pesquisa;
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalGeral = $usu->recuperaTotalPerfil($idPerfil);
$totalPesquisa = $usu->recuperaTotalPerfil($idPerfil,$pesquisa);
$TPL->QUANTIDADE = $totalGeral;
$configPaginacao = $usu->paginar($totalPesquisa,$pagina);
$alist = $usu->listarUsuariosPerfil($idPerfil,$configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa);
$perfil->getById($idPerfil);
$TPL->ID_PERFIL_HASH = $usu->md5_encrypt($idPerfil);
$TPL->DESC_PERFIL = $perfil->descricao;

//gera  a barra de maximo
if($maximo != 0){
$TPL->MAXIMO = $maximo;
$percent = ceil(($totalGeral*100)/$maximo);
$TPL->LIMITE = $percent;
$TPL->block("BLOCK_BARRA_PROGRESSO");
if($totalGeral < $maximo){
	$TPL->block("BLOCK_INCLUIR");
}
}else
{
	$TPL->block("BLOCK_INCLUIR");
}


if (count($alist) > 0) {
foreach($alist as $key => $usuario){
	$TPL->nome = $usuario->nome;
	$TPL->cpf = $usu->formataCPFCNPJ($usuario->cpf);
	$TPL->perfil = $usuario->perfil->descricao;
	$TPL->situacao = $usuario->ativo == 1 ? "Ativo" : "Inativo";
	$TPL->ID_HASH = $usu->md5_encrypt($usuario->id);

	if($usuario->empresa != null){
		$TPL->empresa = $usuario->empresa->nomeFantasia;
	}

	$TPL->block("BLOCK_ITEM_LISTA");
	$TPL->clear("empresa");
}
}

$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$TPL->block("BLOCK_PAGINACAO");
}

$TPL->show();
?>