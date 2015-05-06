<?php
class Acesso extends Persistencia{
	var $menu = NULL;
	var $perfil = NULL;
	
	
	function limparAcessos($idPerfil){
	$sql = "delete from fmj_acesso where fmj_perfil_id = ".$idPerfil;
	$this->DAO_ExecutarQuery($sql);
	return true; 	
	}
	
	public function recuperaMenuAcessos($idPerfil){
	$sql = "select * from fmj_acesso where fmj_perfil_id = ".$idPerfil;    
	return $this->getSQL($sql);		
		
	}
	
}
?>