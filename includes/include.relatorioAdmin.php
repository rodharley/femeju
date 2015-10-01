<?php
//MONTAGEM DO MENU
$obj = new Configuracoes();
$rs = $obj->getRows();
foreach ($rs as $key => $value) {
	switch ($value->id) {
		
        case Configuracoes::ID_CABECALHO:
            $TPL->CONF_CABECALHO = $value->valor;
            break;      
        case Configuracoes::ID_RODAPE:
            $TPL->CONF_RODAPE = $value->valor;
            break;          
         
            
	}
}
?>