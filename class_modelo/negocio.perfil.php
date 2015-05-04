<?php
class Perfil extends Persistencia{
	const GESTOR = 0;	
	const ENG_ADM = 1;
	const ENG_MAN = 2;
	const COND_ADM = 3;
	const COND_MAN = 4;
	const COND_PORT = 5;
	const PROPRIETARIO = 6;	
	var $descricao;
	
	function listarPorPerfil(){
        return $this->getRows(0,999,array(),array("id"=>" >= ".$_SESSION['grc.userPerfilId']));        
    }
    
    
	public function alterar(){
		$oAcesso = new Acesso();
		$idPerfil = $this->md5_decrypt($_POST['id']);
		$this->getById($idPerfil);
		$this->descricao = $_POST['descricao'];
		$this->save();
		$oAcesso->limparAcessos($idPerfil);
		if(isset($_REQUEST['menus'])){
		foreach ($_REQUEST['menus'] as $key => $valor){
		$oAc = new Acesso();
		$m = new Menu();
		$m->id = $valor;
		$oAc->menu = $m;
		$oAc->perfil = $this;
		$oAc->save();	
		}
		}
		$_SESSION['grc.mensagem'] = 9;
		header("Location:perfil-listar");
		exit();
	}
	
}
?>