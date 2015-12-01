<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.iso-8859-1', 'portuguese');
header('Content-Type: text/html; charset=iso-8859-1');
//setando a funcao de tratamento de erros geral

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler('handleError',E_ALL);
//classes do frame work
require("class_arquitetura/conexao.php");
require("class_arquitetura/biblioteca.php");
require("class_arquitetura/persistencia.php");
require("class_arquitetura/template.php");
require("class_arquitetura/mensagem.php");
$conn = Conexao::init();
try{



//incluindo todas as classes e incicializando a conexao com o banco de dados
require("class_modelo/classes.php");
$root = new Persistencia();

//recuperando as variaveis constantes controller e acao
require("constantes.php");
//carregando os controlers
require("controllers.php");
//finalizando os controlers
require("shutdow.php");
}catch(Exception $e){
    
    //print_r($e);
    //echo $_SERVER['HTTP_HOST'];
    //exit();

    $TPL = new Template(URI."/templates/portal/layout.html");
	$TPL->addFile("CONTEUDO", URI."/templates/erro/erro500.html");
	if (DESENVOLVIMENTO)
		$TPL->ALERT = "Mensagem:".$e->getMessage()."<br/>"."Arquivo:".$e->getFile()."<br/>Linha:".$e->getLine();
    $conn->connection->rollback();
    $TPL->show();
}

?>