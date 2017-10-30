<?php
class Competicao extends Persistencia {
     const TABELA = "fmj_competicao";
    var $descricao;
    var $titulo;
    var $dataEvento;    
	var $inscricaoAberta;
    var $dataInscricao;
	var $dataPagamento;
	var $dataDesconto;
	var $percentDesconto;
    var $ativo;
    var $tipo;
    var $dobra1;
    var $dobra2;
    var $dobra3;
    var $custa = NULL;
    var $competicao;
    
    public function Incluir(){
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->competicao = $_REQUEST['competicao'];
        $this->titulo = $_REQUEST['titulo'];
        $this->custa = new Custa($_REQUEST['custa']);
        $this->dobra1 = 0;
        $this->dobra2 = 0;
        $this->dobra3 = 0;
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->dataInscricao = $this->convdata($_REQUEST['dataInscricao'], "ntm");
		$this->dataPagamento = $this->convdata($_REQUEST['dataPagamento'], "ntm");
        $this->dataDesconto = $this->convdata($_REQUEST['dataDesconto'], "ntm");
		$this->percentDesconto = str_replace("_", "", $_REQUEST['percentDesconto']);
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
        if(isset($_REQUEST['dobra1'])){
        $this->dobra1 = $_REQUEST['dobra1'] != "" ? $this->money($_REQUEST['dobra1'], "bta") : 0;
        $this->dobra2 = $_REQUEST['dobra2'] != "" ? $this->money($_REQUEST['dobra2'], "bta") : 0;
        $this->dobra3 = $_REQUEST['dobra3'] != "" ? $this->money($_REQUEST['dobra3'], "bta") : 0;
        }
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->dataInscricao = $this->convdata($_REQUEST['dataInscricao'], "ntm");
		$this->dataPagamento = $this->convdata($_REQUEST['dataPagamento'], "ntm");
        $this->dataDesconto = $this->convdata($_REQUEST['dataDesconto'], "ntm");
		$this->percentDesconto = str_replace("_", "", $_REQUEST['percentDesconto']);
        $this->inscricaoAberta = $_REQUEST['inscricao'];
        $this->ativo = $_REQUEST['ativo'];
        $this->save();
        
        //apaga as categorias
        $this->deletaClasses($this->id);
        if(isset($_REQUEST['classe'])){
        foreach ($_REQUEST['classe'] as $key => $value) {
        $this->insereClasse($value);
        }
        }
        return true;
      
    }
     
     
    function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));        
        $this->deletaClasses($this->id);        
        if (!$this -> delete($this -> id))
            echo $_SESSION['fmj.mensagem'] = 69;            
        
            
        
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
        
        $sql .= "  order by dataEvento asc limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    public function listaAtivasAbertas(){
        return $this->getRows(0,999,array(),array("ativo"=>"=1","inscricaoAberta"=>"=1", "dataInscricao"=>">='".date("Y-m-d")."'"));
    }
	public function listaAtivas(){
        return $this->getRows(0,999,array(),array("ativo"=>"=1"));
    }
	public function listaTodas(){
        return $this->getRows(0,99999,array("dataInscricao"=>"desc"),array());
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
				 
				 
				 //verificar se tem desconto e esta no prazo. Se tiver calcula os valores em cima dele
				$dataVencimento  = $this->dataPagamento;
				$desconto = 0;
				if($this->dataDesconto != ""){
					if(date("Ymd") <= str_replace("-", "", $this->dataDesconto)){
						$dataVencimento  = $this->dataDesconto;
						$desconto = $this->money(($this->percentDesconto/100),"bta");
					}
				}
				 
			         //salva a inscricao
                $insc = new Inscricao();
                $insc->atleta = $atleta;
                $insc->nomeAtleta = $atleta->pessoa->getNomeCompleto();
                $insc->docAtleta = $atleta->pessoa->rg;
                $insc->telefoneAtleta = $atleta->pessoa->telCelular;
                $insc->emailAtleta =$atleta->pessoa->email;
                $insc->dataInscricao = date("Y-m-d");
                $insc->situacao = 0;                
                $insc->valor = $this->money($this->custa->valor - ($this->custa->valor*$desconto),"bta");
                $insc->competicao = $this;
                $insc->graduacao = new Graduacao($_REQUEST['graduacao'.$id]);
								
				                
                if($this->competicao == 1){ 
                $insc->dobra1 = $_REQUEST['dobra1'.$id] != "" ? new Classe($_REQUEST['dobra1'.$id]) : null;
                $insc->valorDobra1 = $_REQUEST['dobra1'.$id] != "" ? $this->money($this->dobra1-($this->dobra1*$desconto),"bta") : 0;
                $insc->dobra2 = $_REQUEST['dobra2'.$id] != "" ? new Classe($_REQUEST['dobra2'.$id]) : null;
                $insc->valorDobra2 = $_REQUEST['dobra2'.$id] != "" ? $this->money($this->dobra2 -($this->dobra2*$desconto),"bta"): 0;
                $insc->dobra3 = $_REQUEST['dobra3'.$id] != "" ? new Classe($_REQUEST['dobra3'.$id]) : null;
                $insc->valorDobra3 = $_REQUEST['dobra2'.$id] != "" ? $this->money($this->dobra3 -($this->dobra3*$desconto),"bta") : 0;
                $insc->classe = new Classe($_REQUEST['classe'.$id]);
                $insc->categoria = new CategoriaPeso($_REQUEST['categoria'.$id]);
                }
                $insc->responsavel = new Usuario($_SESSION['fmj.userId']);
				$insc->associacao = new Associacao($_REQUEST['idAssociacao']);
                
                $idsInscricao .= ",".$insc->save();   
                
                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = $atleta;
                //soma o valor total
                $total = $this->money($this->custa->valor - ($this->custa->valor*$desconto),"bta");
                if($this->competicao == 1){  
                $total += $_REQUEST['dobra1'.$id] != "" ? $this->money($this->dobra1 -($this->dobra1*$desconto),"bta") : 0;
                $total += $_REQUEST['dobra2'.$id] != "" ? $this->money($this->dobra2 -($this->dobra2*$desconto),"bta") : 0;
                $total += $_REQUEST['dobra3'.$id] != "" ? $this->money($this->dobra3 -($this->dobra3*$desconto),"bta") : 0;
                }
                $item->valor = $this->money($total,"bta"); 
                $item->custa = $this->custa;
                $item->descricaoItem = $atleta->pessoa->getNomeCompleto();   
                array_push($itensPagamento,$item);        
                }				
                $resp = new Pessoa();
                $arrayResp = $resp->gerarArraySacado($_SESSION['fmj.userId']);  
				
				
                $idPagamento = $pag->gerarPagamento(GrupoCusta::COMPETICAO,$_REQUEST['tipoPagamento'],$dataVencimento,$arrayResp,$this->titulo, $itensPagamento,isset($_REQUEST['especial']) ? $_REQUEST['especial'] : 0);
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
				
				
				 //verificar se tem desconto e esta no prazo. Se tiver calcula os valores em cima dele
				$dataVencimento  = $this->dataPagamento;
				$desconto = 0;
				if($this->dataDesconto != ""){
					if(date("Ymd") <= str_replace("-", "", $this->dataDesconto)){
						$dataVencimento  = $this->dataDesconto;
						$desconto = ($this->percentDesconto/100);
					}
				}
				
				
                
                if(isset($arrAtleta['id']) && $arrAtleta['id'] != ""){
                
                    $obAtleta = new Atleta();
                    if($obAtleta->getById($arrAtleta['id'])){                        
                        $insc->atleta = $obAtleta;
                    }else{
                        $insc->atleta = NULL;
                           
                    }
                }else{
                    $insc->atleta = NULL;
                }
                
                
                $insc->nomeAtleta = utf8_decode($arrAtleta['nome']);
                $insc->docAtleta = utf8_decode($arrAtleta['documento']);
                $insc->telefoneAtleta = $arrAtleta['telefone'];
                $insc->emailAtleta =utf8_decode($arrAtleta['email']);
                $insc->dataInscricao = date("Y-m-d");
				$insc->dataNascimento = $this->convdata($arrAtleta['dataNascimento'],"ntm");
                $insc->situacao = 0;
                $insc->valor = $this->custa->valor - ($this->custa->valor*$desconto);                
                $insc->competicao = $this;
                $insc->graduacao = new Graduacao($arrAtleta["graduacao"]);
                if($this->competicao == 1){                
                $insc->dobra1 = $arrAtleta['dobra1'] == "Sim" ? new Classe($arrAtleta["classe1"]) : null;
                $insc->valorDobra1 = $arrAtleta['dobra1'] == "Sim" ? $this->dobra1 -($this->dobra1*$desconto) : 0;
                $insc->dobra2 = $arrAtleta['dobra2'] == "Sim" ? new Classe($arrAtleta["classe2"]) : null;
                $insc->valorDobra2 = $arrAtleta['dobra2'] == "Sim" ? $this->dobra2 -($this->dobra2*$desconto) : 0;
                $insc->dobra3 = $arrAtleta['dobra3'] == "Sim" ? new Classe($arrAtleta["classe3"]) : null;
                $insc->valorDobra3 = $arrAtleta['dobra3'] == "Sim" ? $this->dobra3  -($this->dobra3*$desconto) : 0;
                $insc->classe = new Classe($arrAtleta["classe"]);
                $insc->categoria = new CategoriaPeso($arrAtleta["categoria"]);
                }
				$insc->responsavel = new Usuario($_SESSION['fmj.userId']);
				if(isset($_REQUEST['idAssociacao'])){
				$insc->associacao = new Associacao($_REQUEST['idAssociacao']);
				}else{
					$insc->associacao = null;
				}
                $idsInscricao .= ",".$insc->save();   
                
                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = NULL;
                
                //soma o valor total
                $total = $this->custa->valor- ($this->custa->valor*$desconto);
                 if($this->competicao == 1){  
                $total += $arrAtleta['dobra1'] == "Sim" ? $this->dobra1 -($this->dobra1*$desconto) : 0;
                $total += $arrAtleta['dobra2'] == "Sim" ? $this->dobra2 -($this->dobra2*$desconto) : 0;
                $total += $arrAtleta['dobra3'] == "Sim" ? $this->dobra3 -($this->dobra3*$desconto) : 0;
                 }
                $item->valor = $total; 
                $item->custa = $this->custa;
                $item->descricaoItem = utf8_decode($arrAtleta['nome']);   
                array_push($itensPagamento,$item);        
                }
                $resp = new Pessoa();
                $arrayResp = $resp->gerarArraySacado($_SESSION['fmj.userId']); 
                $idPagamento = $pag->gerarPagamento(GrupoCusta::COMPETICAO,$_REQUEST['tipoPagamento'],$dataVencimento,$arrayResp,$this->titulo,$itensPagamento,isset($_REQUEST['especial']) ? $_REQUEST['especial'] : 0);
                $insc->atualizarPagamentos($idPagamento,$idsInscricao);
                return $idPagamento;
   }



}


            ?>