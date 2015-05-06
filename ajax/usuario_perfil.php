<?php
$menu = 2;
include("configuraAjax.php");
$TPL = new Template("../templates/usuario/ajax_cadastro_perfil.html");
$objPerfil = new Perfil();
$obEmpresa = new Empresa();
$obCond = new Condominio();
$obUsuario = new Usuario();
$iduser = $_REQUEST['iduser'];
$idEmpresaEdicao = 0;
if($_REQUEST['idperfil'] > 0){

if($iduser != 0){
$obUsuario->getById($iduser);
$idEmpresaEdicao = $obUsuario->empresa != null ? $obUsuario->empresa->id : 0;
$TPL->registro = $obUsuario->registro;
}
$TPL->iduser = $iduser;
switch ($_REQUEST['idperfil']) {
	case '1':
		$listaEmpresa = $obEmpresa->getRows();
		foreach ($listaEmpresa as $key => $emp) {
			$TPL->idItem = $emp->id;
			$TPL->labelItem = $emp->nomeFantasia;
			$TPL->checkItem = $idEmpresaEdicao == $emp->id ? "selected" : "";
			$TPL->block("BLOCK_ITEM_EMP");
			$TPL->clear("checkItem");
		}
		$TPL->block("BLOCK_EMPRESA");
		$TPL->block("BLOCK_CREA");
		break;
	
	case '2':
		if($_SESSION['grc.userPerfilId'] == 0){		
			$listaEmpresa = $obEmpresa->getRows();	
			
		foreach ($listaEmpresa as $key => $emp) {
			$TPL->idItem = $emp->id;
			$TPL->labelItem = $emp->nomeFantasia;
			$TPL->checkItem = $idEmpresaEdicao == $emp->id ? "selected" : "";
			$TPL->block("BLOCK_ITEM_EMP");
		}
		}else{
			//perfil 1 para cadastrar o perfil 2
			$obEmpresa->getById($_SESSION['grc.empresaId']);
			$TPL->idItem = $obEmpresa->id;
			$TPL->labelItem = $obEmpresa->nomeFantasia;
			$TPL->checkItem = $idEmpresaEdicao == $obEmpresa->id ? "selected" : "";
			$TPL->block("BLOCK_ITEM_EMP");
		}
		$TPL->block("BLOCK_EMPRESA");
		$TPL->block("BLOCK_NOTCREA");
		break;
	default:
		$TPL->block("BLOCK_NOTCREA");
		if($_SESSION['grc.userPerfilId'] == 0){		
			$listaEmpresa = $obEmpresa->getRows();	
			
		foreach ($listaEmpresa as $key => $emp) {
			$TPL->idItem = $emp->id;
			$TPL->labelItem = $emp->nomeFantasia;
			$TPL->checkItem = $idEmpresaEdicao == $emp->id ? "selected" : "";
			$TPL->block("BLOCK_ITEM_EMP");
		}
		}else{
			//perfil 1 para cadastrar o perfil 2
			$obEmpresa->getById($_SESSION['grc.empresaId']);
			$TPL->idItem = $obEmpresa->id;
			$TPL->labelItem = $obEmpresa->nomeFantasia;
			$TPL->checkItem = $idEmpresaEdicao == $obEmpresa->id ? "selected" : "";
			$TPL->block("BLOCK_ITEM_EMP");
		}
		$TPL->block("BLOCK_EMPRESA");
		$TPL->block("BLOCK_COND");
		
		break;	
	
	
}
$TPL->show();
}
exit();
?>

