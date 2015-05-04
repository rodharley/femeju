<?php
// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
/*$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: GestorCadmo <nao-responda@gestorcadmo.com.br>"."\n"; // remetente
$headers .= "Return-Path: GestorCadmo <nao-responda@gestorcadmo.com.br>"."\n"; // return-path
$envio = mail("rodrigo.cruz76@gmail.com", "Assunto", "Texto", $headers, "-r"."nao-responda@gestorcadmo.com.br");
$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: GestorCadmo <$origem>"."\n"; // remetente
$headers .= "Return-Path: GestorCadmo <$origem>"."\n"; // return-path
$email = mail("$destinatario", "$titulo", "$mensagem", $headers, "-r".$origem);
if($envio)
 echo "Mensagem enviada com sucesso 2";
else
 echo "A mensagem não pode ser enviada 2";

 * 
 */

session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.iso-8859-1', 'portuguese');
header('Content-Type: text/html; charset=iso-8859-1');

require("class_arquitetura/biblioteca.php");
require("class_arquitetura/conexao.php");
require("class_arquitetura/persistencia.php");
require("class_arquitetura/template.php");
require("class_arquitetura/mensagem.php");

$conn = Conexao::init();
//incluindo todas as classes e incicializando a conexao com o banco de dados
require("class_modelo/classes.php");

$email = new Email();
$envio = $email -> mail_html("rodrigo.cruz76@gmail.com", $email -> remetente, "teste de assunto", "<html><b>teste</b> teste2");
if($envio)
 echo "Mensagem enviada com sucesso pela lib ".$email -> remetente;
else
 echo "A mensagem não pode ser enviada pela lib".$email -> remetente;
?>