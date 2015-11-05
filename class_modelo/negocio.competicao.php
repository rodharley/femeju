<?php
class Competicao extends Persistencia {
     const TABELA = "fmj_competicao";
    var $descricao;
    var $titulo;
    var $dataEvento;    
	var $inscricaoAberta;
    var $ativo;
    var $tipo;
    
    public function Incluir(){
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = 0;
        return $this->save();
        
    }
    
     public function Alterar(){
         $this->getById($_REQUEST['id']);
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = $_REQUEST['inscricao'];
        $this->ativo = $_REQUEST['ativo'];
        return $this->save();
        
    }
     
     public function IncluirCategoria(){
         $grupo = new GrupoCompeticao();
         $grupo->competicao = new Competicao($_REQUEST['idCompeticao']);
         $grupo->classe = new Classe($_REQUEST['classe']);
         $grupo->graduacao = new Graduacao($_REQUEST['graduacao']);
         $grupo->categoria = new Classe($_REQUEST['categoria']);
         $grupo->valor = $_REQUEST['valor'] == "" ? 0 : $this->money($_REQUEST['valor'], "bta");
         $grupo->dobra = $_REQUEST['dobra'] == "" ? 0 : $this->money($_REQUEST['dobra'], "bta");
         $grupo->save();
         
     }
     public function AlterarCategoria(){
         $grupo = new GrupoCompeticao();
         $grupo->getById($_REQUEST['idGrupo']);
         $grupo->competicao = new Competicao($_REQUEST['idCompeticao']);
         $grupo->classe = new Classe($_REQUEST['classe']);
         $grupo->graduacao = new Graduacao($_REQUEST['graduacao']);
         $grupo->categoria = new Classe($_REQUEST['categoria']);
         $grupo->valor = $_REQUEST['valor'] == "" ? 0 : $this->money($_REQUEST['valor'], "bta");
         $grupo->dobra = $_REQUEST['dobra'] == "" ? 0 : $this->money($_REQUEST['dobra'], "bta");
         $grupo->save();
         
     }
     
     public function ExcluirCategoria(){
         $grupo = new GrupoCompeticao();
         if(!$grupo->delete($this->md5_decrypt($_REQUEST['id'])))
            echo "Nгo й possнvel excluir esse registro pois o mesmo contйm dados no sistema que nгo podem ser excluнdos.";
         
     }
    
    function pesquisarTotal($ativo = "") {
        $sql = "select count(id) as total from ".$this::TABELA." where 1 = 1 ";
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo";
         
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $ativo = "") {

        $sql = "select * from ".$this::TABELA." where 1 = 1 ";
        
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo";
        
        $sql .= "  order by titulo, descricao limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    public function listaAtivasAbertas(){
        return $this->getRows(0,999,array(),array("ativo"=>"=1","inscricaoAberta"=>"=1"));
    }
   
   public function gerarInscricaoF()
   {
            $atleta = new Atleta();
            $grupoC = new GrupoCompeticao();
            $pag = new Pagamento();
            $itensPagamento = array();
            $idsInscricao = "0";
            $insc = new Inscricao();
             foreach ($_REQUEST['atleta' ] as $key => $id) {
                $atleta->getById($id);
                //salva a inscricao
                $insc = new Inscricao();
                $insc->atleta = $atleta;
                $insc->nomeAtleta = $atleta->pessoa->getNomeCompleto();
                $insc->docAtleta = $atleta->pessoa->rg;
                $insc->telefoneAtleta = $atleta->pessoa->telCelular;
                $insc->emailAtleta =$atleta->pessoa->email;
                $insc->dataInscricao = date("Y-m-d");
                $insc->situacao = 0;
                $grupoC->getById($_REQUEST['grupo'.$id]);
                $insc->valor = $grupoC->valor;
                $insc->dobra = isset($_REQUEST['dobra'.$id]) ? 1 : 0;
                $insc->valorDobra = isset($_REQUEST['dobra'.$id]) ? $grupoC->dobra : 0;
                $insc->competicao = $this;
                $insc->grupoCompeticao = $grupoC;
                $idsInscricao .= ",".$insc->save();   
                
                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = $atleta;
                $item->valor = isset($_REQUEST['dobra'.$id]) ? $grupoC->valor+$grupoC->dobra : $grupoC->valor;
                $item->custa = new Custa(1);
                $item->descricaoItem = "Inscriзгo - Competiзгo: ".$this->titulo.", Atleta: ".$atleta->pessoa->getNomeCompleto();   
                array_push($itensPagamento,$item);        
                }
                $idPagamento = $pag->gerarPagamento(GrupoCusta::COMPETICAO,$_REQUEST['tipoPagamento'],$this->dataEvento,$_SESSION['fmj.userId'],$itensPagamento);
                $insc->atualizarPagamentos($idPagamento,$idsInscricao);
                return $idPagamento;
   }


}


            ?>