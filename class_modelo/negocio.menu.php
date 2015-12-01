<?php
class Menu extends Persistencia {
	var $nome;
	var $url;
	var $menuPai = NULL;
	var $ordem;
	var $subMenus;
	var $icone;
    var $visivel;

public function recuperaMenus($superior = null,$validos){
	if($superior != null)
		$sql = "select * from fmj_menu where idMenuPai = $superior and id in($validos) order by ordem";
	else
		$sql = "select * from fmj_menu where idMenuPai is null and id in($validos) order by ordem";
	return $this->getSQL($sql);				
	}


public function recuperaMenusCompletos($idMenuPai = 0){
	if($idMenuPai != null)
		$sql = "select * from fmj_menu where idMenuPai = $idMenuPai order by ordem";
	else
		$sql = "select * from fmj_menu where idMenuPai is null order by ordem";
	return $this->getSQL($sql);				
	}

}
?>