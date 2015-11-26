<?php
class Ano extends Persistencia{
	var $anoReferencia;
	var $dataVencimento;
    
    function listaAnuidades(){
        return $this->getRows(0,999,array("anoReferencia"=>"desc"));
    }
    
    function getByAno($ano){
        return $this->getRow(array("anoReferencia"=>"= $ano"));
    }
    
    function gerar(){
        $ano = $_REQUEST['ano'];
        $vencimento = $this->convdata($_REQUEST['dataVencimento'], "ntm");
        
           if(strlen($ano) == 4 && is_numeric($ano) ){            
            if($this->getRow(array("anoReferencia"=>"=".$ano))){
                 $_SESSION['fmj.mensagem'] = 54;
                return false; 
           }else{
            $this->dataVencimento = $vencimento;
            $this->anoReferencia = $ano;
            $this->save();
            }
           $_SESSION['fmj.mensagem'] = 50;
            return true; 
        }else{
           $_SESSION['fmj.mensagem'] = 51;
           return false; 
        }
    }
    
    function editar(){
        $this->getById($_REQUEST['id']);
        $this->anoReferencia = $_REQUEST['ano'];
        $this->dataVencimento = $this->convdata($_REQUEST['dataVencimento'], "ntm");
        $this->save();
          $_SESSION['fmj.mensagem'] = 64;  
    }
    
    function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 65;
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
}
?>