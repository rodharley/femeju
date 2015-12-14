<?php
try{
    $headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Femeju <contato@judobrasilia.com.br>"."\n"; // remetente
$headers .= "Return-Path: Femeju <contato@judobrasilia.com.br>"."\n"; // return-path
$email = @mail("rodrigo.cruz76@gmail.com", "teste", "teste de mensagem", $headers, "-rcontato@judobrasilia.com.br");    
            
    return $email;
    }catch(exception $e){
        echo $e->getMessage();
    }
?>