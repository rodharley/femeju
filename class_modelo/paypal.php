<?php
class Paypal {
	
	var $sandbox;
	
public function __construct($sandbox = true){
        $this->sandbox = $sandbox;                      
    }	
/**
 * Envia uma requisição NVP para uma API PayPal.
 *
 * @param array $requestNvp Define os campos da requisição.
 * @param boolean $sandbox Define se a requisição será feita no sandbox ou no
 *                         ambiente de produção.
 *
 * @return array Campos retornados pela operação da API. O array de retorno poderá
 *               ser vazio, caso a operação não seja bem sucedida. Nesse caso, os
 *               logs de erro deverão ser verificados.
 */
function sendNvpRequest(array $requestNvp)
{
    //Endpoint da API
    $apiEndpoint  = 'https://api-3t.' . ($this->sandbox? 'sandbox.': null);
    $apiEndpoint .= 'paypal.com/nvp';
 
    //Executando a operação
    $curl = curl_init();
 
    curl_setopt($curl, CURLOPT_URL, $apiEndpoint);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestNvp));
 
    $response = urldecode(curl_exec($curl));
 
    curl_close($curl);
 
    //Tratando a resposta
    $responseNvp = array();
 
    if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
        foreach ($matches['name'] as $offset => $name) {
            $responseNvp[$name] = $matches['value'][$offset];
        }
    }
 
    //Verificando se deu tudo certo e, caso algum erro tenha ocorrido,
    //gravamos um log para depuração.
    if (isset($responseNvp['ACK']) && $responseNvp['ACK'] != 'Success') {
        for ($i = 0; isset($responseNvp['L_ERRORCODE' . $i]); ++$i) {
            $message = sprintf("PayPal NVP %s[%d]: %s\n",
                               $responseNvp['L_SEVERITYCODE' . $i],
                               $responseNvp['L_ERRORCODE' . $i],
                               $responseNvp['L_LONGMESSAGE' . $i]);
 
            error_log($message);
        }
    }
 
    return $responseNvp;
}


function setExpressCheckout($requestNvp){
	//Vai usar o Sandbox, ou produção?

 	$user = PAYPAL_USER;
    $pswd = PAYPAL_PSWD;
    $signature = PAYPAL_SIGNATURE;
//Baseado no ambiente, sandbox ou produção, definimos as credenciais
//e URLs da API.
if ($this->sandbox = true) {
    //credenciais da API para o Sandbox
/*
    $user = 'conta-business_api1.test.com';
    $pswd = '1365001380';
    $signature = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacA-p.YLGfQjc0EobtODs.fMJNajCx';
*/
 
    //URL da PayPal para redirecionamento, não deve ser modificada
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
    //credenciais da API para produção
/*
    $user = 'usuario';
    $pswd = 'senha';
    $signature = 'assinatura';
*/
 
    //URL da PayPal para redirecionamento, não deve ser modificada
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
}
 

 
//Envia a requisição e obtém a resposta da PayPal
$responseNvp = $this->sendNvpRequest($requestNvp);
 
//Se a operação tiver sido bem sucedida, redirecionamos o cliente para o
//ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {
    $query = array(
        'cmd'    => '_express-checkout',
        'token'  => $responseNvp['TOKEN']
    );
 
    $redirectURL = sprintf('%s?%s', $paypalURL, http_build_query($query));
 
    header('Location: ' . $redirectURL);
	exit();
} else {
    //Opz, alguma coisa deu errada.
    //Verifique os logs de erro para depuração.
    unset($_SESSION['idPagamento']);
    header('Location: ' . PAYPAL_CANCELURL);
	exit();
}
}


function doExpressCheckoutPayment($requestNvp){
 	$user = PAYPAL_USER;
    $pswd = PAYPAL_PSWD;
    $signature = PAYPAL_SIGNATURE;
//Baseado no ambiente, sandbox ou produção, definimos as credenciais
//e URLs da API.
if ($this->sandbox = true) {
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
}
 
 
//Envia a requisição e obtém a resposta da PayPal
$responseNvp = $this->sendNvpRequest($requestNvp); 
//Se a operação tiver sido bem sucedida, redirecionamos o cliente para o
//ambiente de pagamento.
if (isset($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS']) && $responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'COMPLETED') {
	$pagamento = new Pagamento();	
	$pagamento->getById($_SESSION['idPagamento']);
	$pagamento->numeroFebraban = $responseNvp['TRANSACTIONID'];
	$pagamento->bitPago =1;
	$pagamento->codigo = $responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'].'-'.$responseNvp['PAYMENTINFO_0_PENDINGREASON'];	
	$pagamento->save();
    header('Location: ' . PAYPAL_TICKETURL);
	exit();
} else {    
    unset($_SESSION['idPagamento']);
    header('Location: ' . PAYPAL_CANCELURL);
	exit();
}
}


}