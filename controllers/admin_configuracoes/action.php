<?php
$menu = 26;
include("includes/include.lock.php");
//INSTACIA CLASSES
$obj = new Configuracoes();
$obj->Alterar();
$_SESSION['fmj.mensagem'] = 40;
header("Location:admin_configuracoes-main");
exit();

?>