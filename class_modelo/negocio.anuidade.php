<?php
class Anuidade extends Persistencia{
    const TABELA ="fmj_anuidade";
    
	var $anoReferencia;
	var $atleta = NULL;
	var $pagamento = NULL;
    var $ano = NULL;
	var $situacao;	
    
    function listaPorAtleta($idAtleta){
        return $this->getRows(0,999,array("anoReferencia"=>"DESC"),array("atleta"=>"=".$idAtleta));
    }
    
    
	
    
    function atualizarAnuidades($idPagamento,$objAno){                
         foreach ($_REQUEST['atleta'] as $key => $id) {
             $this->getRow(array("anoReferencia"=>"=".$objAno->anoReferencia,"atleta"=>"=".$id));
             $this->anoReferencia = $objAno->anoReferencia;
             $this->ano = $objAno;
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