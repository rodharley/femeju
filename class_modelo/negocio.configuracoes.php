<?php
class Configuracoes extends Persistencia {
    const ID_EMAIL_CONTATO = 1;
    const ID_EMAIL_PUSH = 2;
    const ID_TWITTER = 3;
    const ID_FACEBOOK = 4; 
    const ID_INSTAGRAN = 5;
    const ID_RSS = 6;
    const ID_CABECALHO = 7;
    const ID_RODAPE = 8;
    const ID_TITULO = 9;
	const ID_COR_CARTERINHA = 10;
	const ID_ASSINATURA = 11;
   var $valor;
   var $descricao;     
        
  public function Alterar(){
      foreach ($_REQUEST['id'] as $key => $value) {
          $this->getById($value);
          $this->valor = $_REQUEST['configuracao'][$key];
          $this->save();
      }
	  
	  if ($_FILES['assinatura']['name'] != "") {
	  	 	$this->getById($this::ID_ASSINATURA);
            $this -> apagaImagem($this -> valor, "img/");
            $nomefoto = "assinatura.png";
            $this -> uploadImagem($_FILES['assinatura'], $nomefoto, "img/");
            $this -> valor = $nomefoto;			
			$this->save();
        }
  }
}
?>
