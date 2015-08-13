<?php
class Diretoria extends Persistencia{
	var $descricao;
	var $usuario = NULL;
	
    function getByResponsavel($idResp){
        return $this->getRow(array("usuario"=>"=$idResp"));
    }
    
    
    function Excluir($id) {
        $post = new Post();    
        $this->getById($this -> md5_decrypt($id));
        $post->excluirPostsCategoria($post->id);
        if($this -> delete($this->id))
        $_SESSION['fmj.mensagem'] = 35;
        else
        $_SESSION['fmj.mensagem'] = 17;
        header("Location:admin_diretoria-main");
        exit();
    }
        
	public function Alterar(){
		$idDiretoria = $this->md5_decrypt($_POST['id']);
		$this->getById($idDiretoria);
		$this->descricao = $_POST['descricao'];
        $this->usuario = new Usuario($_POST['usuario']);
		$this->save();
		$_SESSION['fmj.mensagem'] = 34;
		header("Location:admin_diretoria-main");
		exit();
	}
	
    public function Incluir(){
        $this->descricao = $_POST['descricao'];
        $this->usuario = new Usuario($_POST['usuario']);
        $this->save();
        
        $_SESSION['fmj.mensagem'] = 33;
        header("Location:admin_diretoria-main");
        exit();
    }
}
?>