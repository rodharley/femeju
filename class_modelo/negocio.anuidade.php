<?php
class Anuidade extends Persistencia{
    const TABELA ="fmj_anuidade";
    
	var $anoReferencia;
	var $atleta = NULL;
	var $pagamento = NULL;
	var $situacao;	
    
    function listaPorAtleta($idAtleta){
        return $this->getRows(0,999,array("anoReferencia"=>"DESC"),array("atleta"=>"=".$idAtleta));
    }
    
    
	function gerar(){
	    $ano = $_REQUEST['ano'];
        $vencimento = $this->convdata($_REQUEST['dataVencimento'], "ntm");
        $objAno = new Ano();
           if(strlen($ano) == 4 && is_numeric($ano) ){            
            if($objAno->getRow(array("anoReferencia"=>"=".$ano))){
                 $_SESSION['fmj.mensagem'] = 54;
                return false; 
           }else{
            $objAno->dataVencimento = $vencimento;
            $objAno->anoReferencia = $ano;
            $objAno->save(); 
            $obAtleta = new Atleta();
            $obAtleta->desativarTodos();
            }
           $_SESSION['fmj.mensagem'] = 50;
            return true; 
        }else{
           $_SESSION['fmj.mensagem'] = 51;
           return false; 
        }
	}
    
    function atualizarAnuidades($idPagamento,$ano){
         foreach ($_REQUEST['atleta'] as $key => $id) {
             $this->getRow(array("anoReferencia"=>"=".$ano,"atleta"=>"=".$id));
             $this->anoReferencia = $ano;
             $this->pagamento = new Pagamento($idPagamento);
             $this->atleta = new  Atleta($id);
             $this->situacao = 0;  
             $this->save();           
             
         }
         return true;
    }
    
    function geraItensPagamento(){
        $itens = array();
        
        foreach ($_REQUEST['atleta'] as $key => $id) {
            $item = new PagamentoItem();
            $atleta = new Atleta();
            $atleta->getById($id);
            $item->atleta = $atleta;
            $item->valor = $_REQUEST['valor_atleta'.$id];
            $item->custa = new Custa($_REQUEST['custa'.$id]);
            $item->descricaoItem = $atleta->pessoa->getNomeCompleto();
            array_push($itens,$item);
        }
        return $itens;
    }
}
?>