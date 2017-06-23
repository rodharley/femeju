<?php
$menu = 0;
include("includes/include.lock.php");
$conf = new Configuracoes();
$pagamento = new Pagamento();
$custa = new Custa();
$pagamento->getById($pagamento->md5_decrypt($_REQUEST['id']));
$descricaoPagamento = $pagamento->descricao."<br/>";
foreach ($pagamento->itens as $key => $item) {
    $custa->getById($item->custa);
	$descricaoPagamento .= $item->descricaoItem.",";
}

$order = new stdClass();
$order->OrderNumber = $pagamento->id;
$order->SoftDescriptor = $pagamento->nomeSacado;
$order->Cart = new stdClass();
/*$order->Cart->Discount = new stdClass();
$order->Cart->Discount->Type = 'Percent';
$order->Cart->Discount->Value = 0;*/
$order->Cart->Items = array();
$order->Cart->Items[0] = new stdClass();
$order->Cart->Items[0]->Name = $pagamento->descricao;
$order->Cart->Items[0]->Description = $descricaoPagamento;
$order->Cart->Items[0]->UnitPrice = str_replace(".", "", $pagamento->valorTotal);
$order->Cart->Items[0]->Quantity = 1;
$order->Cart->Items[0]->Type = 'Service';
$order->Cart->Items[0]->Sku = 'Sku do item no carrinho';
$order->Cart->Items[0]->Weight = 1;
$order->Shipping = new stdClass();
$order->Shipping->Type = 'WithoutShipping';
/*$order->Shipping->SourceZipCode = '14400000';
$order->Shipping->TargetZipCode = '11000000';
$order->Shipping->Address = new stdClass();
$order->Shipping->Address->Street = 'Endereço de entrega';
$order->Shipping->Address->Number = '123';
$order->Shipping->Address->Complement = '';
$order->Shipping->Address->District = 'Bairro da entrega';
$order->Shipping->Address->City = 'Cidade da entrega';
$order->Shipping->Address->State = 'SP';
$order->Shipping->Services = array();
$order->Shipping->Services[0] = new stdClass();
$order->Shipping->Services[0]->Name = 'Serviço de frete';
$order->Shipping->Services[0]->Price = 123;
$order->Shipping->Services[0]->DeadLine = 15;
$order->Payment = new stdClass();
$order->Payment->BoletoDiscount = 0;
$order->Payment->DebitDiscount = 10;*/
$order->Customer = new stdClass();
$order->Customer->Identity = $pagamento->cpfSacado;
$order->Customer->FullName = $pagamento->nomeSacado;
$order->Customer->Email = 'fulano@email.com';
$order->Customer->Phone = '11999999999';
$order->Options = new stdClass();
$order->Options->AntifraudEnabled = false;

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://cieloecommerce.cielo.com.br/api/public/v1/orders');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($order));
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'MerchantId: 00000000-0000-0000-0000-000000000000',
    'Content-Type: application/json'
));

$response = curl_exec($curl);

curl_close($curl);

$json = json_decode($response);
echo $response;

/*$nossoNumero = $boleto->gerarNossoNumero();
$numeroFebraban = $boleto->getNumeroFebraban();
$pagamento->codigo = $nossoNumero;
$pagamento->numeroFebraban = $numeroFebraban;
$pagamento->save();*/

