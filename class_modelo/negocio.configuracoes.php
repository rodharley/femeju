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
    const BRB_CC = 12;
    const BRB_AG = 13;
    const BRB_CA = 14;
    const BRB_DV_CC = 15;
    const BRB_DV_AG = 16;
    const BRB_INSTRUCOES = 17;
	const ID_COR_PORTAL = 18;
   var $valor;
   var $descricao;     
        
  public function Alterar(){
      foreach ($_REQUEST['id'] as $key => $value) {
          $this->getById($value);
          $this->valor = $_REQUEST['configuracao'][$key];
          $this->save();
		  
		  //MUDA A COR DO PORTAL NO CSS
		  if($value == 18){
		  	$file = fopen("css/colors.css", "w+");
			  fwrite($file, ":root {--cor-principal: ".$this->valor.";}");
			  fclose($file);
		  }
		  
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
  
  public function recuperaConfiguracoesBRB(){
      $sql= "Select * from fmj_configuracoes where id in (12,13,14,15,16,17)";
      $arrayValues = array();
      $rs = $this->DAO_ExecutarQuery($sql);
        while($linha = $this->DAO_GerarArray($rs)){
           $arrayValues[$linha['id']] = $linha['valor'];
        }
       return $arrayValues;
  }
}
?>
