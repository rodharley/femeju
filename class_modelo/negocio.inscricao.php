<?php
class Inscricao extends Persistencia {
     const TABELA = "fmj_inscricao_competicao";
    var $nomeAtleta;
    var $telefoneAtleta;
    var $emailAtleta;    
	var $docAtleta;
    var $dataInscricao;
    var $situacao;
    
    var $valorDobra1;
    var $valorDobra2;
    var $valorDobra3;
    var $valor;    
    var $dobra1 = NULL;
    var $dobra2 = NULL;
    var $dobra3 = NULL;
    var $competicao = NULL;
    var $atleta = NULL;
    var $graduacao = NULL;
    var $classe = NULL;
    var $categoria = NULL;
    var $pagamento = NULL;   
    
    
    function atualizarPagamentos($idPagamento,$ids){
        $objPag = new Pagamento();
        $objPag->getById($idPagamento);
         $sql = "update ".$this::TABELA." set idPagamento = ".$idPagamento.", situacao = ".$objPag->bitPago." where id in (".$ids.")";
         $this->DAO_ExecutarDelete($sql);
         return true;
    }
    
    function atualizarInscricoes($idPagamento){
        $objPag = new Pagamento();
        $objPag->getById($idPagamento);
         $sql = "update ".$this::TABELA." set situacao = ".$objPag->bitPago." where idPagamento = ".$idPagamento;
         $this->DAO_ExecutarDelete($sql);
         return true;
    }
}
?>