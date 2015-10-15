<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/servicos/carteirinha.html");
$atleta = new Atleta();
$associacao = new Associacao();
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
$TPL->DATA_NASCIMENTO = $atleta->convdata($atleta->pessoa->dataNascimento, "mtn");
$TPL->NOME = $atleta->pessoa->nome." ".$atleta->pessoa->sobrenome;
$TPL->ASSOCIACAO = $atleta->associacao->nome;
$TPL->FOTO = $atleta->pessoa->foto;
$TPL->REGISTRO = $atleta->getId(); 
$TPL->GRADUACAO = $atleta->graduacao->descricao." - ".$atleta->graduacao->faixa;
$TPL->DATA_EMISSAO = date("d",strtotime($atleta->dataEmissaoCarteira))." de ".$atleta->mesExtenso(date("m",strtotime($atleta->dataEmissaoCarteira)))." de ".date("Y",strtotime($atleta->dataEmissaoCarteira));
$TPL->show();
?>