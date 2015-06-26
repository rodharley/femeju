<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/filebrowser/main.html");
$obj = new FileBrowser();
$arr = $obj->dirToArray("documentos/treinamento");
//$arr = $obj->scanDiretorio("comunicados");

foreach ($arr as $key => $value) {
    if(is_array($value)){
        if(count($value) > 0){
            
            foreach ($value as $key2 => $value2) {
                if(!is_array($value2)){                    
                $TPL->NOME_FILE = $value2;
                $TPL->DIRETORIO = "comunicados/$key/";
                $TPL->TIPO_FILE = $obj->retornaTipo($value2);
                $TPL->block("BLOCK_FILE");
                }
            }
            $TPL->CONTANO = count($value);
        $TPL->IDANO = $key;
        $TPL->NOMEANO = $key;
        $TPL->block("BLOCK_ANO");
        }
    }else{
        
    }
	
}

$TPL->FB_TITULO = "Treinamento";
$TPL->FB_LOGO = "treinamento";
$TPL->show();
?>