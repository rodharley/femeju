<?php
class Noticia extends Persistencia {
    var $titulo;
    var $texto;
    var $foto;
    var $data;

    function pesquisarTotal($titulo = "", $texto = "", $periodo = "") {
        $sql = "select count(id) as total from fmj_noticia where 1 = 1";

        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";

        if ($texto != "")
            $sql .= " and texto like '%$texto%'";

        if ($periodo != "") {
            $arrayData = explode("-", str_replace(" ", "", $periodo));
            $sql .= " and data between '" . $this -> convdata($arrayData[0], "ntm") . " 00:00:00' and '" . $this -> convdata($arrayData[1], "ntm") . " 23:59:59' ";
        }
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $titulo = "", $texto = "", $periodo = "") {

        $sql = "select * from fmj_noticia where 1 = 1";

        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";

        if ($texto != "")
            $sql .= " and texto like '%$texto%'";

        if ($periodo != "") {
            $arrayData = explode("-", str_replace(" ", "", $periodo));
            $sql .= " and data between '" . $this -> convdata($arrayData[0], "ntm") . " 00:00:00' and '" . $this -> convdata($arrayData[1], "ntm") . " 23:59:59' ";
        }

        $sql .= "  order by data limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }
    function listar3PortalTotal(){
        $sql = "select count(*) as total from fmj_noticia";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function listar3Portal($primeiro = 0, $quantidade = 9999){
        $sql = "select * from fmj_noticia order by data desc limit $primeiro, $quantidade";
        return $this->getSQL($sql);
    }
    function Incluir() {
        $this -> titulo = $_REQUEST['titulo'];
        $this -> texto = $_REQUEST['texto'];
        $this -> foto = "";
        $this -> data = date("Y-m-d H:i:s");
        if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/noticias/");
            $this -> uploadImagem($_FILES['foto'], $nomefoto, "img/noticias/");
            $this -> foto = $nomefoto;
        }
        $this -> save();
        $_SESSION['fmj.mensagem'] = 18;
        header("Location:admin_noticia-main");
        exit();

    }

    function Alterar() {

        $this -> getById($_REQUEST['id']);
        $this -> titulo = $_REQUEST['titulo'];
        $this -> texto = $_REQUEST['texto'];
        $this -> data = date("Y-m-d H:i:s");

        //incluir imagem se ouver
        if ($_FILES['foto']['name'] != "") {
            if ($this -> foto != "")
                $this -> apagaImagem($this -> foto, "img/noticias/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/noticias/");
            $this -> uploadImagem($_FILES['foto'], $nomefoto, "img/noticias/");
            $this -> foto = $nomefoto;
        }

        $this -> save();

        $_SESSION['fmj.mensagem'] = 19;
        header("Location:admin_noticia-main");
        exit();

    }

    function salvarFoto($file, $nome, $diretorio) {
        $return = $this -> createthumb($file['name'], $file['tmp_name'], $diretorio . $nome, 215, 215);
    }

    function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> foto != "")
                $this -> apagaImagem($this -> foto, "img/noticias/");
        
        if ($this -> delete($this -> id))
            $_SESSION['fmj.mensagem'] = 20;
        else
            $_SESSION['fmj.mensagem'] = 17;
        header("Location:admin_noticia-main");
        exit();
    }

}
?>