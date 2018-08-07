<?php
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

 
$options = [
			  'client_id' => GN_CLIENTID,
			  'client_secret' => GN_CLIENTSECRET,
			  'sandbox' => GN_SANDBOX // altere conforme o ambiente (true = desenvolvimento e false = producao)
			];
 
 
 /*
* Este token ser� recebido em sua vari�vel que representa os par�metros do POST
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
  // Para identificar o status atual da sua transa��o voc� dever� contar o n�mero de situa��es contidas no array, pois a �ltima posi��o guarda sempre o �ltimo status. Veja na um modelo de respostas na se��o "Exemplos de respostas" abaixo.
/*
$chargeNotification =array("code"=>200,"data"=>array(0=>array(
 "created_at"=>"2018-04-03 07:33:30", // data da altera��o do status do array "id 4"
            "custom_id"=>null, // identificador da cobran�a definido pelo integrador, se existir
            "id"=>1,
            "identifiers"=>array( // identificadores que representam a cobran�a
                "charge_id"=>449271)
            ,
            "received_by_bank_at"=>"2018-04-02", // data do pagamento da cobran�a
            "status"=>array(
                "current"=>"paid", // status ATUAL da transa��o: paid ("pago")
                "previous"=>"unpaid" // status ANTERIOR da transa��o: unpaid ("n�o pago")
            ),
            "type"=>"charge", // tipo da cobran�a que sofreu a altera��o (neste caso, "charge" quer dizer que a altera��o ocorreu em uma transa��o)
            "value"=>6990)));

  */
  // Veja abaixo como acessar o ID e a String referente ao �ltimo status da transa��o.
    
    // Conta o tamanho do array data (que armazena o resultado)
    $i = count($chargeNotification["data"]);
  
    // Pega o �ltimo Object chargeStatus
    $ultimoStatus = $chargeNotification["data"][$i-1];
	
    // Acessando o array Status
    $status = $ultimoStatus["status"];
    // Obtendo o ID da transa��o    
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo a String do status atual
    $statusAtual = $status["current"];
    
    // Com estas informa��es, voc� poder� consultar sua base de dados e atualizar o status da transa��o especifica, uma vez que voc� possui o "charge_id" e a String do STATUS
  	
  	
  	$opag = new Pagamento();
	if($opag->getByChargeId($charge_id)){
		$opag->gnStatus = $statusAtual;
		$opag->save();
		if($statusAtual == "paid") {			
			$opag->baixaPagamento($opag->id,$ultimoStatus['received_by_bank_at']);			 
		}
				
	}else{
		echo "Pagamento n�o encontrado!";
	}
  	
  
    echo "O id da transa��o �: ".$charge_id." seu novo status �: ".$statusAtual;
 
    //print_r($chargeNotification);
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}
}else{
	echo "Token n�o recebido!";
}
