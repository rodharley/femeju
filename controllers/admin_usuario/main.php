<?php
$menu = 2;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");

//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
			                        <h1>
			                            Usuários
			                            <small>Lista de Usuários</small>
			                        </h1>
			                        <ol class="breadcrumb">
			                            <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
			                            <li><a href="admin_perfil-main"><i class="fa fa-user"> </i> Usuário</a></li>
			                             <li class="active">Listar</li>
			                        </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/usuario/list.html");
$TPL->LOADING = $usu->carregando;
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$idperfil = isset($_REQUEST['perfil']) ? $_REQUEST['perfil'] : "0";
$TPL->PESQUISA = $pesquisa;
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $usu->recuperaTotal($pesquisa);
$configPaginacao = $usu->paginar($totalPesquisa,$pagina);
$alist = $usu->listarUsuarios($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa);

$rsPerfil = $perfil->getRows();
foreach ($rsPerfil as $key => $value) {
    $TPL->SELECTED_PERFIL = "";
    $TPL->ID_PERFIL = $value->id;
    $TPL->DESC_PERFIL = $value->descricao;
    if($idperfil == $value->id)
        $TPL->SELECTED_PERFIL = "SELECTED";
	$TPL->block("ITEM_PERFIL");
}

if (count($alist) > 0) {
foreach($alist as $key => $usuario){
	$TPL->nome = $usuario->pessoa->nome;
	$TPL->cpf = $usu->formataCPFCNPJ($usuario->pessoa->cpf);
	$TPL->perfil = $usuario->perfil->descricao;
	$TPL->situacao = $usuario->ativo == 1 ? "Ativo" : "Inativo";
	$TPL->ID_HASH = $usu->md5_encrypt($usuario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
	
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