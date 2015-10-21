<?php
$menu = 0;
include("includes/include.lock.php");
$conf = new Configuracoes();
$pagamento = new Pagamento();
$custa = new Custa();
$brbarray = $conf->recuperaConfiguracoesBRB();
$pagamento->getById($pagamento->md5_decrypt($_REQUEST['id']));
$descricaoPagamento = "";
foreach ($pagamento->itens as $key => $item) {
    $custa->getById($item->custa);
	$descricaoPagamento .= $item->descricaoItem."-".$custa->descricao."<br/>";
}
require 'plugins/openboleto/autoloader.php';


use OpenBoleto\Banco\Brb;
use OpenBoleto\Agente;


$sacado = new Agente($pagamento->responsavel->pessoa->getNomeCompleto(), $pagamento->responsavel->pessoa->cpf, $pagamento->responsavel->pessoa->endereco, $pagamento->responsavel->pessoa->bairro, $pagamento->responsavel->pessoa->cidade->nome, $pagamento->responsavel->pessoa->cidade->uf->uf);
$cedente = new Agente('Femeju - Federa��o Metropolitana de Judo', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Bras�lia', 'DF');

$boleto = new Brb(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime($pagamento->dataVencimento),
    'valor' => $pagamento->valorTotal,
    'sequencial' => $pagamento->id, // Até 6 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => $brbarray[13], // Até 3 dígitos
    'carteira' => $brbarray[14], // 1 ou 2
    'conta' => $brbarray[12], // Até 7 dígitos

    // Parâmetros recomendáveis
    'logoPath' => 'img/logo.png', // Logo da sua empresa
    'contaDv' => $brbarray[15],
    'agenciaDv' => $brbarray[16],
    'descricaoDemonstrativo' => array( // Ate 5
        $descricaoPagamento
    ),
    'instrucoes' => array( // Ate 8
        $brbarray[17],        
    ),

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'moeda' => Brb::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'numeroDocumento' => '123.456.789',
    //'usoBanco' => 'Uso banco',
    //'layout' => 'layout.phtml',
    //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
    //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
    //'descontosAbatimentos' => 123.12,
    //'moraMulta' => 123.12,
    //'outrasDeducoes' => 123.12,
    //'outrosAcrescimos' => 123.12,
    //'valorCobrado' => 123.12,
    //'valorUnitario' => 123.12,
    //'quantidade' => 1,
));
echo $boleto->getOutput();
