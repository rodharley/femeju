<?php
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

 
$options = [
			  'client_id' => GN_CLIENTID,
			  'client_secret' => GN_CLIENTSECRET,
			  'sandbox' => GN_SANDBOX // altere conforme o ambiente (true = desenvolvimento e false = producao)
			];
 
 
 /*
* Este token será recebido em sua variável que representa os parâmetros do POST
* Ex.: $_POST['notification']
*/
if(isset($_POST["notification"])){
$token = $_POST["notification"];
 
$params = [
  'token' => $token
];
 
try {
	$api = new Gerencianet($options);
    $chargeNotification = $api->getNotification($params, []);
  // Para identificar o status atual da sua transação você deverá contar o número de situações contidas no array, pois a última posição guarda sempre o último status. Veja na um modelo de respostas na seção "Exemplos de respostas" abaixo.
/*
$chargeNotification =array("code"=>200,"data"=>array(0=>array(
 "created_at"=>"2018-04-03 07:33:30", // data da alteração do status do array "id 4"
            "custom_id"=>null, // identificador da cobrança definido pelo integrador, se existir
            "id"=>1,
            "identifiers"=>array( // identificadores que representam a cobrança
                "charge_id"=>449271)
            ,
            "received_by_bank_at"=>"2018-04-02", // data do pagamento da cobrança
            "status"=>array(
                "current"=>"paid", // status ATUAL da transação: paid ("pago")
                "previous"=>"unpaid" // status ANTERIOR da transação: unpaid ("não pago")
            ),
            "type"=>"charge", // tipo da cobrança que sofreu a alteração (neste caso, "charge" quer dizer que a alteração ocorreu em uma transação)
            "value"=>6990)));

  */
  // Veja abaixo como acessar o ID e a String referente ao último status da transação.
    
    // Conta o tamanho do array data (que armazena o resultado)
    $i = count($chargeNotification["data"]);
  
    // Pega o último Object chargeStatus
    $ultimoStatus = $chargeNotification["data"][$i-1];
	
    // Acessando o array Status
    $status = $ultimoStatus["status"];
    // Obtendo o ID da transação    
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo a String do status atual
    $statusAtual = $status["current"];
    
    // Com estas informações, você poderá consultar sua base de dados e atualizar o status da transação especifica, uma vez que você possui o "charge_id" e a String do STATUS
  	
  	
  	$opag = new Pagamento();
	if($opag->getByChargeId($charge_id)){
		$opag->gnStatus = $statusAtual;
		$opag->save();
		if($statusAtual == "paid") {			
			$opag->baixaPagamento($opag->id,$ultimoStatus['received_by_bank_at']);			 
		}
				
	}else{
		echo "Pagamento não encontrado!";
	}
  	
  
    echo "O id da transação é: ".$charge_id." seu novo status é: ".$statusAtual;
 
    //print_r($chargeNotification);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
}else{
	echo "Token não recebido!";
}
