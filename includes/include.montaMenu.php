<?php
//MONTAGEM DO MENU
$menuob = new Menu();
$listaMenu = $menuob->recuperaMenus(null,$_SESSION['grc.menu']);
foreach ($listaMenu as $key => $menu) {
	$TPL->CLASS_MENU = "";
	$TPL->MENU_SETA = "";	
	if($menu->url != ""){
		$TPL->DESC_MENU = $menu->nome;
		$TPL->URL_MENU = $menu->url;
		$TPL->ICON_MENU = $menu->icone;		
	}else{
		$TPL->DESC_MENU = $menu->nome;
		$TPL->ICON_MENU = $menu->icone;
		$TPL->CLASS_MENU = "treeview";
		$TPL->MENU_SETA = '<i class="fa fa-angle-left pull-right"></i>';
		$subs = $menuob->recuperaMenus($menu->id,$_SESSION['grc.menu']);
		foreach ($subs as $key2 => $submenu) {
			$TPL->DESC_SUBMENU = $submenu->nome;
			$TPL->URL_SUBMENU = $submenu->url;			
			$TPL->block("BLOCK_SUBMENU");
		}		
		$TPL->block("BLOCK_MENU_DROPDOWN");
	}
	$TPL->block("BLOCK_MENU");
}

$TPL->NOME_USER = $_SESSION['grc.userNome'];
$TPL->FOTO_USER = $_SESSION['grc.userFoto'];	
$TPL->NOME_PERFIL = $_SESSION['grc.userPerfil'];
?>