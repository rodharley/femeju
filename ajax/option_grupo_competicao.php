<?php
$menu = 0;
include("configuraAjaxSemLogin.php");
$obj = new GrupoCompeticao();
$graduacao = isset($_REQUEST['graduacao']) ?$_REQUEST['graduacao']:"";
$categoria = isset($_REQUEST['categoria']) ?$_REQUEST['categoria']:"";
$classe = isset($_REQUEST['classe']) ?$_REQUEST['classe']:""; 
echo "<option value=''></option>";
$lista = $obj->listar($_REQUEST['competicao'],$graduacao,$categoria,$classe);
foreach ($lista as $key => $value) {
switch ($_REQUEST['nivel']) {
    case '0':
        echo "<option value='".$value->graduacao->id."'>".$value->graduacao->descricao."</option>";
    break;
	case '1':
	   echo "<option value='".$value->categoria->id."'>".$value->categoria->descricao."</option>";	
		break;
    case '2':
        echo "<option value='".$value->classe->id."'>".$value->classe->descricao."</option>";
    break;
    case '0':
        echo "<option value='".$value->graduacao->id."'>".$value->graduacao->descricao."</option>";
    break;
	default:
		    echo "<option value='".$value->graduacao->id."'>".$value->graduacao->descricao."</option>";
		break;
}    
}
exit();
?>