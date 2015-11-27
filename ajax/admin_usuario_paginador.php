<?php
$menu = 2;
include("configuraAjax.php");
//INSTACIA CLASSES
$usu = new Usuario();
$perfil = new Perfil();
//verificar se perfil selecionado




$TPL = new Template("../templates/admin/usuario/list.html");
$pesquisa = isset($_REQUEST['pesquisa']) ? $_REQUEST['pesquisa'] : "";
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$idperfil = isset($_REQUEST['perfil']) ? $_REQUEST['perfil'] : "";
$totalPesquisa = $usu->recuperaTotal($pesquisa,$idperfil);
$configPaginacao = $usu->paginar($totalPesquisa,$pagina);
$alist = $usu->listarUsuarios($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$pesquisa,$idperfil);
if (count($alist) > 0) {
foreach($alist as $key => $usuario){
	$TPL->nome = $usuario->pessoa->nome." ".$usuario->pessoa->nomeMeio." ".$usuario->pessoa->sobrenome;
	$TPL->cpf = $usu->formataCPFCNPJ($usuario->pessoa->cpf);
	$TPL->perfil = $usuario->perfil->descricao;
	$TPL->situacao = $usuario->ativo == 1 ? "Ativo" : "Inativo";
	$TPL->ID_HASH = $usu->md5_encrypt($usuario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
	
}
}
$TPL->paginar_class = 'paginar';
$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$TPL->block("BLOCK_PAGINACAO");
}
$TPL->show();

exit();
?>

