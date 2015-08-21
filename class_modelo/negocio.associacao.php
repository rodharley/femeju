<?php
class Associacao extends Persistencia {
    const TABELA = "fmj_associacao";
    var $nome;
    var $razaoSocial;
    var $sigla;
    var $cnpj;
    var $descricao;
    var $logomarca;
    var $dataFiliacao;
    var $endereco;
    var $bairro;
    var $cidade = NULL;
    var $cep;
    var $responsavel;
    var $celular;
    var $telefone1;
    var $telefone2;
    var $email;
    var $webSite;
    var $midiaSocial;
    var $ativo;

public function listaPermissoes($idUsuario){
    $sql = "select a.* from fmj_academia a inner join fmj_permissao p on a.id = p.idAcademia where p.idUsuario = $idUsuario";
    return $this->getSQL($sql);
}

function pesquisarTotal($nome = "") {
        $sql = "select count(id) as total from ".$this::TABELA." where bitAtivo = 1 ";

        if ($nome != "")
            $sql .= " and ( nome like '%$nome%' or razaoSocial like '%$nome%')";

                $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $nome = "") {

        $sql = "select * from ".$this::TABELA." where bitAtivo = 1 ";

        if ($nome != "")
            $sql .= " and ( nome like '%$nome%' or razaoSocial like '%$nome%')";

        $sql .= "  order by nome limit $primeiro, $quantidade";
        
        return $this -> getSQL($sql);

    }

   
}
?>