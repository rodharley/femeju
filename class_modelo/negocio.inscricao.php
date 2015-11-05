<?php
class Inscricao extends Persistencia {
     const TABELA = "fmj_inscricao_competicao";
    var $nomeAtleta;
    var $telefoneAtleta;
    var $emailAtleta;    
	var $docAtleta;
    var $dataInscricao;
    var $situacao;
    var $valorDobra;
    var $valor;
    var $dobra;
    var $competicao = NULL;
    var $atleta = NULL;
    var $grupoCompeticao = NULL;
    var $pagamento = NULL;   
    
    
    function atualizarPagamentos($idPagamento,$ids){
         $sql = "update ".$this::TABELA." set idPagamento = ".$idPagamento." where id in (".$ids.")";
         $this->DAO_ExecutarDelete($sql);
         return true;
    }
}
?>