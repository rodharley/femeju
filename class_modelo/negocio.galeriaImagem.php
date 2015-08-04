<?php
class GaleriaImagem extends Persistencia{
	var $galeria = NULL;
	var $imagem;
    
    function listaFotos($idGaleria){
        return $this->getRows(0,999,array(),array("galeria"=>"=".$idGaleria));
    }
    
    function retornaUmaImagem($idGaleria){
        $sql = "select * from fmj_galeria_imagem where idGaleria = $idGaleria limit 1";
        $arrayOb = $this->getSQL($sql);
        if(count($arrayOb) > 0){
        $obj = $arrayOb[0];
        return $obj;
        }else{
            $gi = new GaleriaImagem();
            $gi->imagem = "thumb_galeria.png";
            return $gi;
        }
    }
    
    function AddImagens(){
        $diretorio = "img/galeria/";
       foreach ($_FILES['imagens']['tmp_name'] as $key => $name) {
           $gal = new GaleriaImagem();                   
           $nomefoto = $this -> retornaNomeUnico($_FILES['imagens']['name'][$key],$diretorio);
           copy($_FILES['imagens']['tmp_name'][$key],$diretorio."".$nomefoto);
           $gal->galeria = new Galeria($_POST['id']);
           $gal->imagem = $nomefoto;
           $gal->save();
           
       }
        $_SESSION['fmj.mensagem'] = 30;
            header("Location:admin_galeria-editar?id=".$this->md5_encrypt($_REQUEST['id']));
    }
    
    function ExcluirImagem($idImagem){
        $this->getById($this->md5_decrypt($idImagem));
        unlink("img/galeria/".$this->imagem);
        $this->delete($this->id);
    }
    
}
?>