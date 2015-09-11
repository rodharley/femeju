<?php
//MONTAGEM DO MENU
$obj = new Configuracoes();
$rs = $obj->getRows();
foreach ($rs as $key => $value) {
	switch ($value->id) {
		case Configuracoes::ID_TWITTER:
			$TPL->CONF_TWITTER = $value->valor;
			break;
		case Configuracoes::ID_FACEBOOK:
            $TPL->CONF_FACEBOOK = $value->valor;
            break;
        case Configuracoes::ID_RSS:
            $TPL->CONF_RSS = $value->valor;
            break;
        case Configuracoes::ID_INSTAGRAN:
            $TPL->CONF_INSTAGRAN = $value->valor;
            break;		
        case Configuracoes::ID_TITULO:
            $TPL->CONF_TITULO = $value->valor;
            break;      
        case Configuracoes::ID_CABECALHO:
            $TPL->CONF_CABECALHO = $value->valor;
            break;      
        case Configuracoes::ID_RODAPE:
            $TPL->CONF_RODAPE = $value->valor;
            break;          
         
            
	}
}
?>