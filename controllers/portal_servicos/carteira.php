<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/servicos/carteirinha.html");
$atleta = new Atleta();
$associacao = new Associacao();
$obj = new Configuracoes();
$obj->getById($obj::ID_COR_CARTERINHA);
$atleta->getById($atleta->md5_decrypt($_REQUEST['id']));
if($atleta->ativo == 1 ){
$TPL->COR_CARTEIRINHA = $obj->valor;
$TPL->DATA_NASCIMENTO = $atleta->convdata($atleta->pessoa->dataNascimento, "mtn");
$TPL->NOME = $atleta->pessoa->nome." ".$atleta->pessoa->nomeMeio." ".$atleta->pessoa->sobrenome;
$TPL->ASSOCIACAO = $atleta->associacao->nome;
$TPL->FOTO = $atleta->pessoa->foto;
$TPL->REGISTRO = $atleta->getId(); 
$TPL->GRADUACAO = $atleta->graduacao->descricao." - ".$atleta->graduacao->faixa;
$TPL->ID_HASH = $_REQUEST['id'];
$dttime = strtotime($atleta->dataEmissaoCarteira);
$mes = date("m",$dttime);
$dia = date("d",$dttime);
$ano = date("Y",$dttime);
$val = mktime(0,0,0,12,31,$ano);
$TPL->DATA_EMISSAO = date("d",$val)." de ".$atleta->mesExtenso(date("m",$val))." de ".date("Y",$val);
$TPL->block("BLOCK_CARTEIRA");
}else{
$TPL->block("BLOCK_INATIVO");    
}
$TPL->show();
?>