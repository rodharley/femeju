<?php
$menu = 0;
include("includes/include.lock.php");
$pagamento = new Pagamento();
$paypal = new Paypal(PAYPAL_SANDBOX);
$pagamento->getById($_SESSION['idPagamento']);
$descricaoPagamento = $pagamento->descricao."<br/>";

$requestNvp = array(
    'USER' => PAYPAL_USER,
    'PWD' => PAYPAL_PSWD,
    'SIGNATURE' => PAYPAL_SIGNATURE,
 
    'VERSION' => '114.0',
    'METHOD'=> 'DoExpressCheckoutPayment',
 	'TOKEN' => $_GET['token'],
 	'PAYERID' => $_GET['PayerID'],
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
    'PAYMENTREQUEST_0_AMT' => $pagamento->valorTotal,
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
    'PAYMENTREQUEST_0_ITEMAMT' => $pagamento->valorTotal,
    //'PAYMENTREQUEST_0_INVNUM' => '1234', 
    'L_PAYMENTREQUEST_0_NAME0' => 'Inscri��o',
    'L_PAYMENTREQUEST_0_DESC0' => $descricaoPagamento,
    'L_PAYMENTREQUEST_0_AMT0' => $pagamento->valorTotal,
    'L_PAYMENTREQUEST_0_QTY0' => '1',
    'L_PAYMENTREQUEST_0_ITEMAMT' => $pagamento->valorTotal,
    'RETURNURL' => PAYPAL_RETURNURL,
    'CANCELURL' => PAYPAL_CANCELURL,
    'BUTTONSOURCE' => 'JUDO BRAS�LIA',
    'LOCALECODE' => 'BR',
    'LOGOIMG' => 'http://judobrasilia.com.br/img/icon_gr.png'
); 

$paypal->doExpressCheckoutPayment($requestNvp);