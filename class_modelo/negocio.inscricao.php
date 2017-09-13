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
	var $responsavel = NULL;   
	var $associacao = NULL;   
    
    
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
	function getInscricoes($idCompeticao,$idPagamento){
         return $this->getRows(0,9999,array(),array("competicao"=>"=".$idCompeticao,"pagamento"=>"=".$idPagamento));         
    }
	
	function ExcluirInscricao($idPagamento){
		$objPag = new Pagamento();
		$objPag->getById($idPagamento);
		if($objPag->bitPago == 0){
		$sql = "select * from ".Inscricao::TABELA." where idPagamento = ".$idPagamento;
		$rs = $this->getSQL($sql);
		$idCompeticao = 0;
		 $log = new Log();        
		foreach ($rs as $key => $inscr) {
			$idCompeticao = $inscr->competicao->id;
			$log->gerarLog("Exclusão de Inscrição do responsavel: ".$objPag->nomeSacado.", Atleta: ".$inscr->nomeAtleta);	
			$this->delete($inscr->id);
		}
		
		$objPag->excluir($idPagamento);
		return $idCompeticao;
		}else{
			return 0;
		}		
		
	}
	function atualizarValoresInscricoes(){
		$pag = new Pagamento();
		$pag->getById($_REQUEST['idPagamento']);
		$custa = $pag->itens[0];
		print_r( $custa);
		exit();
		foreach ($_REQUEST['inscricao'] as $key => $idInscricao) {
			$this->getById($idInscricao);
			$this->valor = $this->money($_REQUEST['valor'][$key],"bta");
			$this->valorDobra1 = $this->money($_REQUEST['valor_dobra1'][$key],"bta");
			$this->valorDobra2 = $this->money($_REQUEST['valor_dobra2'][$key],"bta");
			$this->valorDobra3 = $this->money($_REQUEST['valor_dobra3'][$key],"bta");
			
		}
	}
}
?>