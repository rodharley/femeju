<?php
class Inscricao extends Persistencia {
     const TABELA = "fmj_inscricao_competicao";
    var $nomeAtleta;
    var $telefoneAtleta;
    var $emailAtleta;    
	var $docAtleta;
    var $dataInscricao;
    var $situacao;
    var $dobra1;
    var $dobra2;
    var $dobra3;
    var $valorDobra1;
    var $valorDobra2;
    var $valorDobra3;
    var $valor;    
    var $competicao = NULL;
    var $atleta = NULL;
    var $graduacao = NULL;
    var $classe = NULL;
    var $categoria = NULL;
    var $pagamento = NULL;   
    
    
    function atualizarPagamentos($idPagamento,$ids){
         $sql = "update ".$this::TABELA." set idPagamento = ".$idPagamento." where id in (".$ids.")";
         $this->DAO_ExecutarDelete($sql);
         return true;
    }
}
?>