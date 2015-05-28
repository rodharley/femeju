<?php
class Academia extends Persistencia {
    var $nome;
    var $registro;
    var $logradouro;
    var $cep;
    var $bairro;
    var $telComercial;
    var $cidade = NULL;

public function listaPermissoes($idUsuario){
    $sql = "select a.* from fmj_academia a inner join fmj_permissao p on a.id = p.idAcademia where p.idUsuario = $idUsuario";
    return $this->getSQL($sql);
}
    
}
?>