<?php
class Perfil extends Persistencia{
	const RESPONSAVEL = 3;
    const ADMINISTRADOR = 1;    
    const ARBITRAGEM = 2;
	var $descricao;
    
	
	function listarPorPerfil(){
        return $this->getRows(0,999,array(),array("id"=>" >= ".$_SESSION['fmj.userPerfilId']));        
    }
    
        function Excluir($id) {
        $this->getById($this -> md5_decrypt($id));
        if($this -> delete($this->id))
        $_SESSION['fmj.mensagem'] = 67;
        else
        $_SESSION['fmj.mensagem'] = 17;
        header("Location:admin_perfil-main");
        exit();
    }
        
	public function Alterar(){
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
		$_SESSION['fmj.mensagem'] = 9;
		header("Location:admin_perfil-main");
		exit();
	}
	
    public function Incluir(){
        $oAcesso = new Acesso();
        $this->descricao = $_POST['descricao'];
        $this->save();
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
        $_SESSION['fmj.mensagem'] = 21;
        header("Location:admin_perfil-main");
        exit();
    }
}
?>