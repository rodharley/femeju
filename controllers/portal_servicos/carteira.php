<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/servicos/carteirinha.html");
$atleta = new Atleta();
$associacao = new Associacao();
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
$TPL->NACIONALIDADE = $atleta->pessoa->nacionalidade;
$TPL->NATURALIDADE = $atleta->pessoa->naturalidade != null ? $atleta->pessoa->naturalidade->nome."-".$atleta->pessoa->naturalidade->uf->uf : "";
$TPL->DATA_NASCIMENTO = $atleta->convdata($atleta->pessoa->dataNascimento, "mtn");
$TPL->CPF = $atleta->formataCPFCNPJ($atleta->pessoa->cpf);
$TPL->NOME = $atleta->pessoa->nome." ".$atleta->pessoa->sobrenome;
$TPL->ASSOCIACAO = $atleta->associacao->nome;
$TPL->DATA_REGISTRO = $atleta->convdata($atleta->dataFiliacao, "mtn");
$TPL->FOTO = $atleta->pessoa->foto;
$TPL->REGISTRO_CBJ = $atleta->registroConfederacao;
$TPL->REGISTRO = $atleta->getId(); 
$TPL->RG = $atleta->pessoa->rg;
$TPL->FILIACAO = $atleta->pessoa->filiacaoPai." e ".$atleta->pessoa->filiacaoMae;
$TPL->DATA_EMISSAO = date("d",strtotime($atleta->dataEmissaoCarteira))." de ".$atleta->mesExtenso(date("m",strtotime($atleta->dataEmissaoCarteira)))." de ".date("Y",strtotime($atleta->dataEmissaoCarteira));
$TPL->show();
?>