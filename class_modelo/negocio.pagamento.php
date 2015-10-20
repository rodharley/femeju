<?php
class Pagamento extends Persistencia{
	var $valorTotal;	
    var $dataVencimento;
    var $dataPagamento;
    var $bitPago;  
    var $codigo;        
    var $tipo = NULL;
    var $responsavel = NULL;
    var $grupo;
    
    public function gerarPagamento($grupo,$tipoPagamento,$dataVencimento,$usuarioResponsavel,$itensPagamento){
        $total = 0;
        foreach ($itensPagamento as $key => $item) {
            $total += $item->valor;
        }    
        $this->valorTotal = $total;
        $this->dataVencimento = $dataVencimento;
        $this->dataPagamento = NULL;
        $this->bitPago = 0;
        $this->grupo = $grupo;
        $this->responsavel = new Usuario($usuarioResponsavel);
        $this->tipo = new PagamentoTipo($tipoPagamento);
        $this->save();
        
        foreach ($itensPagamento as $key => $item) {
         $item->pagamento = $this;
         $item->save();
             
        }
        return $this->id;
    }
}
?>