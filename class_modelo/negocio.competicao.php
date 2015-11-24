<?php
class Competicao extends Persistencia {
     const TABELA = "fmj_competicao";
    var $descricao;
    var $titulo;
    var $dataEvento;    
	var $inscricaoAberta;
    var $ativo;
    var $tipo;
    var $dobra1;
    var $dobra2;
    var $dobra3;
    VAR $custa = NULL;
    public function Incluir(){
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->custa = new Custa($_REQUEST['custa']);
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = 0;
        $this->ativo = 1;
        return $this->save();
        
    }
    
     public function Alterar(){
      
         $this->getById($_REQUEST['id']);
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->custa = new Custa($_REQUEST['custa']);
        $this->dobra1 = $this->money($_REQUEST['dobra1'], "bta");
        $this->dobra2 = $this->money($_REQUEST['dobra2'], "bta");
        $this->dobra3 = $this->money($_REQUEST['dobra3'], "bta");
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = $_REQUEST['inscricao'];
        $this->ativo = $_REQUEST['ativo'];
        $this->save();
        
        //apaga as categorias
        $this->deletaClasses($this->id);
        
        foreach ($_REQUEST['classe'] as $key => $value) {
        $this->insereClasse($value);
        }
        return true;
      
    }
     
    function insereClasse($idClasse){
        $grupo = new GrupoCompeticao();
        $grupo->competicao = $this;
        $grupo->classe = new Classe($idClasse);
        $grupo->save();
    } 
     
     
    function deletaClasses($id){
        $sql = "delete from ".GrupoCompeticao::TABELA." where idCompeticao = ".$id;
        $this->DAO_ExecutarDelete($sql);
    }
    
    function listaClasses(){
        $grupo = new GrupoCompeticao();
        return $grupo->getRows(0,999,array(),array("competicao"=>"=".$this->id));
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
                
                $insc->valor = $this->custa->valor;                
                $insc->dobra1 = isset($_REQUEST['dobra1'.$id]) ? 1 : 0;
                $insc->valorDobra1 = isset($_REQUEST['dobra1'.$id]) ? $this->dobra1 : 0;
                $insc->dobra2 = isset($_REQUEST['dobra2'.$id]) ? 1 : 0;
                $insc->valorDobra2 = isset($_REQUEST['dobra2'.$id]) ? $this->dobra2 : 0;
                $insc->dobra3 = isset($_REQUEST['dobra3'.$id]) ? 1 : 0;
                $insc->valorDobra3 = isset($_REQUEST['dobra3'.$id]) ? $this->dobra3 : 0;
                
                $insc->competicao = $this;
                $insc->graduacao = new Graduacao($_REQUEST['graduacao'.$id]);
                $insc->classe = new Classe($_REQUEST['classe'.$id]);
                $insc->categoria = new CategoriaPeso($_REQUEST['categoria'.$id]);
                $idsInscricao .= ",".$insc->save();   
                
                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = $atleta;
                //soma o valor total
                $total = $this->custa->valor;
                $total += isset($_REQUEST['dobra1'.$id]) ? $this->dobra1 : 0;
                $total += isset($_REQUEST['dobra2'.$id]) ? $this->dobra2 : 0;
                $total += isset($_REQUEST['dobra3'.$id]) ? $this->dobra3 : 0;
                $item->valor = $total; 
                $item->custa = $this->custa;
                $item->descricaoItem = "Inscriчуo - Competiчуo: ".$this->titulo.", Atleta: ".$atleta->pessoa->getNomeCompleto();   
                array_push($itensPagamento,$item);        
                }
                $idPagamento = $pag->gerarPagamento(GrupoCusta::COMPETICAO,$_REQUEST['tipoPagamento'],$this->dataEvento,$_SESSION['fmj.userId'],$itensPagamento);
                $insc->atualizarPagamentos($idPagamento,$idsInscricao);
                return $idPagamento;
   }
    
    public function gerarInscricaoA($atletas)
   {
            
            $grupoC = new GrupoCompeticao();
            $pag = new Pagamento();
            $itensPagamento = array();
            $idsInscricao = "0";
            $insc = new Inscricao();
             foreach ($atletas as $key => $arrAtleta) {                
                //salva a inscricao
                $insc = new Inscricao();
                $insc->atleta = NULL;
                $insc->nomeAtleta = utf8_decode($arrAtleta['nome']);
                $insc->docAtleta = utf8_decode($arrAtleta['documento']);
                $insc->telefoneAtleta = $arrAtleta['telefone'];
                $insc->emailAtleta =utf8_decode($arrAtleta['email']);
                $insc->dataInscricao = date("Y-m-d");
                $insc->situacao = 0;
                $insc->valor = $this->custa->valor;                
                $insc->dobra1 = $arrAtleta['dobra1'] == "Sim" ? 1 : 0;
                $insc->valorDobra1 = $arrAtleta['dobra1'] == "Sim" ? $this->dobra1 : 0;
                $insc->dobra2 = $arrAtleta['dobra2'] == "Sim" ? 1 : 0;
                $insc->valorDobra2 = $arrAtleta['dobra2'] == "Sim" ? $this->dobra2 : 0;
                $insc->dobra3 = $arrAtleta['dobra3'] == "Sim" ? 1 : 0;
                $insc->valorDobra3 = $arrAtleta['dobra3'] == "Sim" ? $this->dobra3 : 0;
                $insc->competicao = $this;
                $insc->graduacao = new Graduacao($arrAtleta["graduacao"]);
                $insc->classe = new Classe($arrAtleta["classe"]);
                $insc->categoria = new CategoriaPeso($arrAtleta["categoria"]);
                $idsInscricao .= ",".$insc->save();   
                
                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = NULL;
                
                //soma o valor total
                $total = $this->custa->valor;
                $total += $arrAtleta['dobra1'] == "Sim" ? $this->dobra1 : 0;
                $total += $arrAtleta['dobra2'] == "Sim" ? $this->dobra2 : 0;
                $total += $arrAtleta['dobra3'] == "Sim" ? $this->dobra3 : 0;
                $item->valor = $total; 
                $item->custa = $this->custa;
                $item->descricaoItem = "Inscriчуo - Competiчуo: ".$this->titulo.", Atleta: ".utf8_decode($arrAtleta['nome']);   
                array_push($itensPagamento,$item);        
                }
                $idPagamento = $pag->gerarPagamento(GrupoCusta::COMPETICAO,$_REQUEST['tipoPagamento'],$this->dataEvento,$_SESSION['fmj.userId'],$itensPagamento);
                $insc->atualizarPagamentos($idPagamento,$idsInscricao);
                return $idPagamento;
   }

}


            ?>