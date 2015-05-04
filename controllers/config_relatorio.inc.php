<?php
if(!isset($_SESSION['az.userId'])){
header("location:"._GESTOR);
exit();
}
$tpl = new Template($db->URI."html/tpl_relatorio_vertical.html");
//CONFIGURA O GESTOR
$gestor = new Gestor();
$user = new Usuario();
$gestor->getById($_SESSION['az.gestorId']);
$user->getById($_SESSION['az.userId']);
$tpl->NOME = $gestor->nome;
$tpl->LOGO = $gestor->logo;
$tpl->LOGO_OPERADORA = $gestor->operadora.'.png';
//CONFIGURA O USUARIO
$tpl->NOME_USUARIO = $user->nome;
$tpl->DATA_ATUAL = 	date("d/m/Y h:i:s");
?>