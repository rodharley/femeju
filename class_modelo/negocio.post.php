<?php
class Post extends Persistencia {
    var $titulo;
    var $mensagem;
    var $texto;
    var $arquivo;
    var $imagem;
    var $data;
    var $categoria;    
    
    function retornaTipo($filename){
      $arr = explode(".", $filename);
      $retorno = "txt";
      if(count($arr) > 1){
          $ext = strtolower(substr($arr[1],0,3));
          $retorno = $ext;
      }
      return $retorno;
  }
    
    
    function listarArrayAnos($categoria){
        $SQL = "select Year(data) as ano from fmj_post where categoria = $categoria group by Year(data) order by ano desc";
        $rs = $this->DAO_ExecutarQuery($SQL);
        $arrayItens = array();
                if($this->DAO_NumeroLinhas($rs) > 0){
                    while($arrayItem = $this->DAO_GerarArray($rs)){
                        array_push($arrayItens,$arrayItem['ano']);
                    }
                }
         return $arrayItens;
    }
    
    function pesquisarTotal($titulo = "", $mensagem = "", $periodo = "",$categoria) {
        $sql = "select count(id) as total from fmj_post where categoria = $categoria";

        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";

        if ($mensagem != "")
            $sql .= " and mensagem like '%$mensagem%'";

        if ($periodo != "") {
            $arrayData = explode("-", str_replace(" ", "", $periodo));
            $sql .= " and data between '" . $this -> convdata($arrayData[0], "ntm") . " 00:00:00' and '" . $this -> convdata($arrayData[1], "ntm") . " 23:59:59' ";
        }
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $titulo = "", $texto = "", $periodo = "",$categoria) {

        $sql = "select * from fmj_post where categoria = $categoria";

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
    function listar3PortalTotal($ano = "",$categoria ){
        $sql = "select count(*) as total from fmj_post where categoria = $categoria";
        if($ano == "")
            $ano = Date("Y");
        $sql .= " and Year(data) = ".$ano;
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function listar3Portal($primeiro = 0, $quantidade = 9999,$ano = "",$categoria){
        $sql = "select * from fmj_post where categoria = $categoria"; 
        if($ano == "")
            $ano = Date("Y");
        $sql .= " and Year(data) = ".$ano;
        
        $sql .= " order by data desc limit $primeiro, $quantidade";
        return $this->getSQL($sql);
    }
    
 
    function Incluir() {
        $this -> titulo = $_REQUEST['titulo'];
        $this -> mensagem = $_REQUEST['mensagem'];
        $this -> texto = $_REQUEST['texto'];
        $this -> data = $this->convdata($_REQUEST['data'],"ntm")." ".date("H:i:s");
        $this -> imagem = "";
        $this -> arquivo = "";
        $this -> categoria = $this->md5_decrypt($_REQUEST['categoria']);
        $obCat = new Categoria();
        $pasta = $obCat->retornaPasta($this->categoria);
        
        if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/".$pasta."/");
            $this -> uploadImagem($_FILES['foto'], $nomefoto, "img/".$pasta."/");
            $this -> imagem = $nomefoto;
        }
        
        if ($_FILES['arquivo']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['arquivo']['name'], "documentos/".$pasta."/");
            $this -> uploadArquivo($_FILES['arquivo'], $nomefoto, "documentos/".$pasta."/");
            $this -> arquivo = $nomefoto;
        }
        $this -> save();
        

    }

    function Alterar() {

        $this -> getById($_REQUEST['id']);
        $this -> titulo = $_REQUEST['titulo'];
        $this -> mensagem = $_REQUEST['mensagem'];
        $this -> texto = $_REQUEST['texto'];
        $this -> data = $this->convdata($_REQUEST['data'],"ntm")." ".date("H:i:s");
        $obCat = new Categoria();
        $pasta = $obCat->retornaPasta($this->categoria);
        
        if(!isset($_REQUEST['haveimagem']) && $this -> imagem != ""){
            $this -> apagaImagem($this -> imagem, "img/".$pasta."/");  
            $this -> imagem = ""; 
        }
        
        if(!isset($_REQUEST['havearquivo']) && $this -> arquivo != ""){
            $this -> apagaImagem($this -> arquivo, "documentos/".$pasta."/");
            $this -> arquivo = "";   
        }
        
        //incluir imagem se ouver
        if ($_FILES['foto']['name'] != "") {
            if ($this -> imagem != "")
                $this -> apagaImagem($this -> imagem, "img/".$pasta."/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/".$pasta."/");
            $this -> uploadImagem($_FILES['foto'], $nomefoto, "img/".$pasta."/");
            $this -> imagem = $nomefoto;
        }
        if ($_FILES['arquivo']['name'] != "") {
            if ($this -> arquivo != "")
                $this -> apagaImagem($this -> arquivo, "documentos/".$pasta."/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['arquivo']['name'], "documentos/".$pasta."/");
            $this -> uploadImagem($_FILES['arquivo'], $nomefoto, "documentos/".$pasta."/");
            $this -> arquivo = $nomefoto;
        }
        $this -> save();
    }

    function salvarFoto($file, $nome, $diretorio) {
        $return = $this -> createthumb($file['name'], $file['tmp_name'], $diretorio . $nome, 215, 215);
    }

    function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        $obCat = new Categoria();
        $pasta = $obCat->retornaPasta($this->categoria);
        if ($this -> imagem != "")
                $this -> apagaImagem($this -> imagem, "img/".$pasta."/");
        if ($this -> arquivo != "")
                $this -> apagaImagem($this -> arquivo, "documentos/".$pasta."/");
        
        return $this -> delete($this -> id);
    }
    
    

}
?>