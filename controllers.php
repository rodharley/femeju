<?php
try{

	if(file_exists("controllers/"._CONTROLLER."/"._ACTION.".php")){
		include("controllers/"._CONTROLLER."/"._ACTION.".php");
	}else{
	$TPL = new Template(URI."/templates/portal/layout.html");
	$TPL->addFile("CONTEUDO", URI."/templates/erro/erro404.html");
	$TPL->show();
	exit();
	}


}catch(Exception $e){
	$TPL = new Template(URI."/templates/portal/layout.html");
	$TPL->addFile("CONTEUDO", URI."/templates/erro/erro500.html");
	if (DESENVOLVIMENTO)
		$TPL->ALERT = "Mensagem:".$e->getMessage()."<br/>"."Arquivo:".$e->getFile()."<br/>Linha:".$e->getLine();
    $conn->connection->rollback();
    $TPL->show();
}

?>