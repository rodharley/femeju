<?php
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
class Pagamento extends Persistencia{
	
	const TABELA = "fmj_pagamento";


	var $valorTotal;
    var $dataVencimento;
    var $dataPagamento;
    var $bitPago;
	var $bitResolvido;
	var $bitEspecial;
    var $codigo;
    var $numeroFebraban;
    var $tipo = NULL;
    var $grupo;
    var $descricao;
    var $nomeSacado;
    var $cpfSacado;
    var $enderecoSacado;
    var $bairroSacado;
    var $cidadeSacado;
    var $ufSacado;
	var $dataEmissao;
    var $itens = array();
	var $forma;
	var $telefone;
	var $gnStatus;
	var $gnChargeId;
	var $gnUrlBoleto;
    public function cancelar($id){
        $this->getById($this->md5_decrypt($id));
        if($this->bitPago == 0){
        	$this -> bitPago = 2;

        	$this -> save();
            $log = new Log();
            $log->gerarLog("Cancelamento de Pagamento");
            $_SESSION['fmj.mensagem'] = 53;

        }else{
            $_SESSION['fmj.mensagem'] = 17;
        }

    }

    public function gerarPagamento($grupo,$tipoPagamento,$dataVencimento,$arrayResponsavel,$descricao, $itensPagamento,$especial=0){
        $total = 0.0;
        foreach ($itensPagamento as $key => $item) {
            $total += $item->valor;
        }
		//$total = $this->money($total,"bta");
        $this->valorTotal = $this->money($total,"bta");
        $this->dataVencimento = $dataVencimento;
        $this->bitResolvido = 1;
        if($total <= 0){
            $this->bitPago = 1;
            $this->dataPagamento = date("Y-m-d");
        }else{
            $this->bitPago = 0;
            $this->dataPagamento = NULL;
        }
		if($especial == 1){
			$this->bitResolvido = 0;
		}
		
        $this->grupo = $grupo;
        $this->descricao = $descricao;
        $this->nomeSacado = $arrayResponsavel['nome'];
        $this->cpfSacado = $arrayResponsavel['cpf'];
        $this->enderecoSacado = $arrayResponsavel['endereco'];
        $this->bairroSacado = $arrayResponsavel['bairro'];
        $this->cidadeSacado = $arrayResponsavel['cidade'];
        $this->ufSacado = $arrayResponsavel['uf'];
		$this->telefone = $arrayResponsavel['telefone'];
        $this->tipo = new PagamentoTipo($tipoPagamento);
		$this->bitEspecial = $especial;
		$this->save();

        foreach ($itensPagamento as $key => $item) {
         $item->pagamento = $this;
         $item->save();

        }

		//trata por tipo de pagamento:
		if($tipoPagamento == 1){
		
			$urlsite = 'http://'.$_SERVER['HTTP_HOST'].'/';
			$options = [
			  'client_id' => GN_CLIENTID,
			  'client_secret' => GN_CLIENTSECRET,
			  'sandbox' => GN_SANDBOX // altere conforme o ambiente (true = desenvolvimento e false = producao)
			];
			
			$itensGN = array();
			foreach ($itensPagamento as $key => $item) {
				$itemadd = [
				    'name' => utf8_encode($item->descricaoItem), // nome do item, produto ou serviço
				    'amount' => 1, // quantidade
				    'value' => intval($this->limpaDigitos($item->valor))// valor (1000 = R$ 10,00)
				];
				$itensGN[$key]=$itemadd;
			}
			$metadata = ['notification_url'=>$urlsite.GN_NOTIFICATIONURL];
			$body  =  [
			    'items' => $itensGN,
			    'metadata' => $metadata
			];
			
			try {
				//registra o pagamento
			    $api = new Gerencianet($options);
			    $charge = $api->createCharge([], $body);
			 //Array ( [code] => 200 [data] => Array ( [charge_id] => 448859 [status] => new [total] => 2000 [custom_id] => [created_at] => 2018-07-26 11:33:30 ) ) 

				$this->gnStatus = $charge['data']['status'];
				$this->gnChargeId = $charge['data']['charge_id'];
				
				
					//seta boleto
					// $charge_id refere-se ao ID da transação gerada anteriormente
						$params = [
						  'id' => intval($this->gnChargeId)
						];
	 					
						$customer = [
						  'name' => count(explode(" ", $this->nomeSacado)) > 1 ? utf8_encode($this->nomeSacado) : utf8_encode($this->nomeSacado+" Femeju"), // nome do cliente
						  'cpf' => $this->cpfSacado , // cpf válido do cliente
						  'phone_number' => strlen($this->limpaDigitos($this->telefone)) > 11 ? substr($this->limpaDigitos($this->telefone),2) : str_pad($this->limpaDigitos($this->telefone),11,"0",STR_PAD_LEFT) // telefone do cliente
						];
 
						$bankingBillet = [
						  'expire_at' => $this->dataVencimento, // data de vencimento do boleto (formato: YYYY-MM-DD)
						  'customer' => $customer
						];
						 
						$payment = [
						  'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
						];
						 
						$body = [
						  'payment' => $payment
						];
			
						 $charge = $api->payCharge($params, $body);
						//Array ( [code] => 200 [data] => Array ( [barcode] => 00000.00000 00000.000000 00000.000000 0 00000000000000 [link] => https://visualizacaosandbox.gerencianet.com.br/emissao/43219_1_CACA2/A4XB-43219-305988-MAXI8 [expire_at] => 2018-07-26 [charge_id] => 449048 [status] => waiting [total] => 6000 [payment] => banking_billet ) ) 
						$this->gnStatus = $charge['data']['status'];
						$this->numeroFebraban = $charge['data']['barcode'];
						$this->gnUrlBoleto = $charge['data']['link'];
						$this->save();
						
			} catch (GerencianetException $e) {
			    print_r($e->code);
			    print_r($e->error);
			    print_r($e->errorDescription);
				exit();
				//grava a log     
				$_SESSION['fmj.param1'] =  $e->error;             
				$_SESSION['fmj.mensagem'] = 85;
    			header("Location:portal_servicos-entrar");
				exit();
				
			} catch (Exception $e) {
			    print_r($e->getMessage());
				exit();
				
				$_SESSION['fmj.mensagem'] = 85;
				$_SESSION['fmj.param1'] =  print_r($e->getMessage());
    			header("Location:portal_servicos-entrar");
				exit();
			}
			
			
		}
        return $this->id;
    }

    function pesquisarTotal($grupo = "",$responsavel = "",$dataVencimentoI = "",$dataVencimentoF = "",$codigo="",$status="",$especial="") {
        $sql = "select count(p.id) as total from ".$this::TABELA." p  where 1 = 1 ";
        if($grupo != "")
            $sql .= " and p.idGrupo = $grupo";
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimentoI != "")
            $sql .= " and ( p.dataVencimento >= '$dataVencimentoI')";
		if ($dataVencimentoF != "")
            $sql .= " and ( p.dataVencimento <= '$dataVencimentoF')";
        if ($codigo != "")
            $sql .= " and ( p.numeroFebraban =  '$codigo' or p.codigo = '$codigo')";
        if ($status != "")
            $sql .= " and ( p.bitPago = $status )";
		if($especial != ""){
		 	$sql .= " and ( p.bitResolvido = $especial )";
		}
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

 function pesquisarPortalTotal($idResponsavel) {
        $sql = "select count(p.id) as total from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacado where pe.id = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);

    }

 function pesquisarPortal($primeiro = 0, $quantidade = 9999, $idResponsavel) {
        $sql = "select p.* from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacado where pe.id = $idResponsavel order by p.dataVencimento desc";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> getSQL($sql);
    }
 function pesquisar($primeiro = 0, $quantidade = 9999, $grupo = "",$responsavel = "",$dataVencimentoI = "",$dataVencimentoF = "",$codigo="",$status="",$especial="") {

        $sql = "select p.* from ".$this::TABELA." p where 1 = 1 ";

        if($grupo != "")
            $sql .= " and idGrupo = $grupo";
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimentoI != "")
            $sql .= " and ( p.dataVencimento >= '$dataVencimentoI')";
		if ($dataVencimentoF != "")
            $sql .= " and ( p.dataVencimento <= '$dataVencimentoF')";
        if ($codigo != "")
            $sql .= " and ( p.numeroFebraban =  '$codigo' or p.codigo = '$codigo')";
        if ($status != "")
            $sql .= " and ( p.bitPago = $status )";
        if($especial != ""){
		 	$sql .= " and ( p.bitResolvido = $especial )";
		}
        $sql .= "  order by p.id desc limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }

	function deleteItens(){
		$sql = "delete from ".PagamentoItem::TABELA." where idPagamento = ".$this->id;
		$this->DAO_ExecutarDelete($sql);
	}
	public function gerarPagamentoOutros($itens)
   {

            $grupoC = new GrupoCompeticao();
            $pag = new Pagamento();
            $itensPagamento = array();
            $custa = new Custa();
            $cidade = new Cidade();
            $cidade->getById($_REQUEST['cidade']);
			$dataPag = $this->convdata($_REQUEST['data'], "ntm");

             foreach ($itens as $key => $i) {
                //gera o item de pagamento
                $item = new PagamentoItem();
                $item->atleta = NULL;
                //soma o valor total
                $custa->getById($i['custa']);
                $total = $custa->valor;
                $item->valor = $total;
                $item->custa = $custa;
                $item->descricaoItem = utf8_decode($i['descricao']);
                array_push($itensPagamento,$item);
                }
				$arrayResp = array();
	            $arrayResp['nome'] = $_REQUEST['nomeSacado'];
	            $arrayResp['cpf'] = $this->limpaDigitos($_REQUEST['cpfcnpj']);
	            $arrayResp['endereco'] = $_REQUEST['endereco'];
	            $arrayResp['bairro'] = $_REQUEST['bairro'];
	            $arrayResp['cidade'] = $cidade->nome;
	            $arrayResp['uf'] = $cidade->uf->uf;
				$arrayResp['telefone'] = $_REQUEST['telefone'];
                $idPagamento = $pag->gerarPagamento(GrupoCusta::OUTROS,$_REQUEST['tipoPagamento'],$dataPag,$arrayResp,$_REQUEST['descricao'],$itensPagamento);
                return $idPagamento;
                 }

                function baixaPagamento($idPagamento){
                    $this->getById($idPagamento);
                    $this->dataPagamento = $this->convdata($_REQUEST['dataPagamento'], "ntm");
					$this->forma = $_REQUEST['forma'];
                    $this->bitPago = 1;
                    $this->save();
                    switch ($this->grupo) {
                        case GrupoCusta::COMPETICAO:
                            $isncr = new Inscricao();
                            $isncr->atualizarInscricoes($this->id);
                            break;
                        case GrupoCusta::ANUIDADE:
                            $anu = new Anuidade();
                            $anu->atualizarAnuidadePorPagamento($this->id);
                            break;
                        default:

                            break;
                    }

                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Baixa no pagamento de número : ".$this->codigo);

                }

function getPagamentosDeCompeticao($idCompeticao){
         return $this->getSQL("SELECT p.* FROM `fmj_pagamento` p inner join fmj_inscricao_competicao i on i.idPagamento = p.id WHERE i.idCompeticao = $idCompeticao group by i.idPagamento");
    }

function getPagamentosEspeciaisPendentes(){
	return $this->getSQL("SELECT p.* FROM `fmj_pagamento` p WHERE bitEspecial = 1 and bitResolvido = 0");
}
function pesquisaRelatorio($datai,$dataf){
	$sql = "select d.* from ".Pagamento::TABELA." d where d.bitPago = 1 and d.dataPagamento between '$datai' and '$dataf'";
	return $this->getSQL($sql);
}

function pesquisarBoletosBrb($dataVencimentoI = "",$dataVencimentoF = "") {

        $sql = "select p.* from ".$this::TABELA." p where 1 = 1 ";


        if ($dataVencimentoI != "")
            $sql .= " and ( p.dataVencimento >= '$dataVencimentoI')";
		if ($dataVencimentoF != "")
            $sql .= " and ( p.dataVencimento <= '$dataVencimentoF')";
        $sql .= " and ( p.bitPago = 0)";
		$sql .= " and ( p.idTipoPagamento = 1)";

        return $this -> getSQL($sql);

    }

}

?>