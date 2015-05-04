<?php
//INSTACIA CLASSES
$usu = new Usuario();
$usu->EnviarSenha($_REQUEST['email']);
header("Location:index.php");
?>