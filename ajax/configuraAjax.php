<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
header("Content-Type: text/html; charset=iso-8859-1");
include("../includes/include.lock.php");
//classes do frame work
require("../class_arquitetura/biblioteca.php");
require("../class_arquitetura/conexao.php");
require("../class_arquitetura/persistencia.php");
require("../class_arquitetura/template.php");
require("../class_arquitetura/mensagem.php");
include("../class_modelo/classes.php");
$conn = Conexao::init();

?>