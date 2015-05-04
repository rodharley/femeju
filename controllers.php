<?php
try{

	if(file_exists("controllers/"._CONTROLLER."/"._ACTION.".php")){
		include("controllers/"._CONTROLLER."/"._ACTION.".php");
	}else{
	$TPL = new Template($root->URI."/templates/portal.html");

	$TPL->addFile("CONTEUDO", $root->URI."/templates/erro/erro404.html");
	$TPL->show();
	exit();
	}


}catch(Exception $e){
	if(isset($_SESSION['grc.userId']))
		$TPL = new Template($root->URI."/templates/main.html");
	else
		$TPL = new Template($root->URI."/templates/index.html");

	$TPL->addFile("CONTEUDO", $root->URI."/templates/erro/erro500.html");
	if ($root->desenvolvimento)
		$TPL->ALERT = "Mensagem:".$e->getMessage()."<br/>"."Arquivo:".$e->getFile()."<br/>Linha:".$e->getLine();

	$TPL->show();
}

?>