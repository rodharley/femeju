<?php
class Anuidade extends Persistencia{
	var $anoReferencia;
	var $atleta = NULL;
	var $pagamento = NULL;
	var $situacao;
	
	function gerar(){
	    $ano = $_REQUEST['ano'];
        if(strlen($ano) == 4 && is_numeric($ano) ){
           $obAtleta = new Atleta();
           $rs = $obAtleta->listaAtivos();
           foreach ($rs as $key => $value) {
               if(!$this->getRow(array("anoReferencia"=>"=".$ano,"atleta"=>"=".$value->id))){
               $this->id = null;    
               $this->anoReferencia = $ano;
                $this->pagamento = null;
                $this->situacao = 0;
               $this->atleta = new Atleta($value->id);
               $this->save();
               if($ano >= Date("Y")){
                $value->ativo = 0;
                $value->save();
               }
               }
           }
           
           $_SESSION['fmj.mensagem'] = 50;
            return true; 
        }else{
           $_SESSION['fmj.mensagem'] = 51;
           return false; 
        }
	}
}
?>