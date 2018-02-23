<?php
class Atleta extends Persistencia {
	const TABELA = "fmj_atleta";
   var $dataFiliacao;   
   var $dataEmissaoCarteira;
   var $registroConfederacao;
   var $ativo;
   var $numeroFemeju;
   var $bitAtleta;
   var $bitArbitro;
   var $bitTecnico;
   var $graduacao = NULL;
   var $associacao = NULL;        
   var $pessoa = NULL;
   var $graduacoes;
   var $anuidades;
   var $observacoes;
   
   public function listaPorAssociacaoAtivos($associacao){
       $sql = "select a.* from ".$this::TABELA." a inner join ".Pessoa::TABELA." p on p.id = a.id where a.bitAtivo = 1 and a.idAssociacao = $associacao order by p.nome";
       return $this->getSQL($sql);
}

public function listaPorAssociacao($associacao){
       $sql = "select a.* from ".$this::TABELA." a inner join ".Pessoa::TABELA." p on p.id = a.id where a.idAssociacao = $associacao order by p.nome";
       return $this->getSQL($sql);
}

public function listaPorAssociacaoInativo($associacao){
       $sql = "select a.* from ".$this::TABELA." a inner join ".Pessoa::TABELA." p on p.id = a.id where a.bitAtivo = 0 and  a.numeroFemeju is not null and a.idAssociacao = $associacao order by p.nome";
       return $this->getSQL($sql);
}


public function listaPorArrayIds($arrayId){
    $ids = "0";
    foreach ($arrayId as $key => $value) {
        $ids .= ",".$value;
    }
       $sql = "select a.* from ".$this::TABELA." a inner join ".Pessoa::TABELA." p on p.id = a.id where a.id in($ids) order by p.nome";
       return $this->getSQL($sql);
}


public function listaAtivos(){
    return $this->getRows(0,99999,array(),array("ativo"=>"=1"));
}
  
  public function getId(){
      return strlen($this->numeroFemeju) > 0 ? str_pad($this->numeroFemeju,5,"0",STR_PAD_LEFT) : "";
  }
  
  public function getSituacao(){
  	if($this->pessoa->bitVerificado == 0)
		return "Aguardando Verificação";
	else if($this->ativo == 0)
		return "Irregular";
	else {
		return "Regular";
	}
  }
  
  public function getProximoNumero(){
  	$sql = "select max(numeroFemeju)+1 as numero from ".$this::TABELA;
  	$rs = $this->DAO_ExecutarQuery($sql);
	$numero = $this->DAO_Result($rs, "numero", 0);
	if($numero == NULL)
		return 1;
	else {
		return $numero;
	}
  }
   
   function recuperaPorIdPessoa($idPessoa) {
        $id = isset($idPessoa) ? $idPessoa == "" ? "0" : $idPessoa  : "0";
        $sql = "select u.* from ".$this::TABELA." u where u.id = $id";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
           $this->getById($rs[0]->id);      
            return true;
        }else
            return false;
    }
    
	function pesquisarTotal($nome = "",$associacao = "",$numero = "",$naoverf = "",$ativo = "") {
        $sql = "select count(a.id) as total from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.id INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao where 1 = 1 ";
        if($ativo != "")
            $sql .= " and a.bitAtivo = $ativo"; 
		if($naoverf != "")
            $sql .= " and p.bitVerificado = $naoverf"; 
        if ($nome != "")
            $sql .= " and (concat(p.nome,' ', p.nomeMeio,' ', p.sobrenome) like '%$nome%' or p.endereco like '%$nome%' or p.bairro like '%$nome%')";
        if ($associacao != "")
            $sql .= " and (concat(x.nome, ' ', x.sigla) like '%$associacao%')";
            if ($numero != "")
            $sql .= " and (a.numeroFemeju  like '$numero%')";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function pesquisarCarteira($nome = "",$associacao = "",$numero = "",$range ="") {

        $sql = "select a.* from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.id INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao  where a.bitAtivo = 1 ";
 
        if ($nome != "")
            $sql .= " and ( concat(p.nome,' ', p.nomeMeio,' ', p.sobrenome) like '%$nome%' or p.endereco like '%$nome%' or p.bairro like '%$nome%')";
        if ($associacao != "")
            $sql .= " and ( x.id = $associacao )";
        if ($numero != ""){
            $numero = str_replace(";", ",", $numero);
            $sql .= " and ( a.numeroFemeju in($numero) )";
            }
        if ($range != ""){
            $range = str_replace(";", ",", $range);
            $arN = explode(",", $range);
            $sql .= " and ( a.numeroFemeju >= ".$arN[0]." and a.numeroFemeju <= ".$arN[1].")";
        }
        $sql .= "  order by a.numeroFemeju desc limit 0,20";     
        
        return $this -> getSQL($sql);

    }
        
    

    function pesquisar($primeiro = 0, $quantidade = 9999, $nome = "",$associacao = "",$numero = "",$naoverf = "",$ativo = "") {

        $sql = "select a.* from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.id INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao  where 1 = 1 ";
        if($naoverf != "")
            $sql .= " and p.bitVerificado = $naoverf";
        if($ativo != "")
            $sql .= " and a.bitAtivo = $ativo"; 
        if ($nome != "")
            $sql .= " and (concat(p.nome,' ', p.nomeMeio,' ', p.sobrenome) like '%$nome%' or p.endereco like '%$nome%' or p.bairro like '%$nome%')";
        if ($associacao != "")
            $sql .= " and (concat(x.nome, ' ', x.sigla) like '%$associacao%')";
        if ($numero != "")
            $sql .= " and (a.numeroFemeju  like '$numero%')";
        
        $sql .= "  order by a.numeroFemeju desc limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    
    
        function pesquisarParaInscricao($nome = "",$associacao = "") {

        $sql = "select a.* from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.id where a.bitAtivo = 1 ";
        
        if ($nome != "")
            $sql .= " and ( concat(p.nome,' ', p.nomeMeio,' ', p.sobrenome) like '%$nome%')";
        if ($associacao != "")
            $sql .= " and (a.idAssociacao in($associacao))";
        
        $sql .= "  order by p.nome limit 0,10";  

        return $this -> getSQL($sql);

    }
    	
	function Verificar($id){
		$this -> getById($id);
		$this->numeroFemeju = $this->getProximoNumero();
		$this->pessoa->bitVerificado = 1;
		$this->pessoa->save();
		$this->save();
		$_SESSION['fmj.mensagem'] = 46;
	}
	
	function desativarTodos(){
	    $sql = "update ".$this::TABELA." set bitAtivo = 0";
	    $this->DAO_ExecutarDelete($sql);
	    $_SESSION['fmj.mensagem'] = 66;
	    return true;
	}
	
    function Incluir() {
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		$objPessoa = new Pessoa();
		
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $associacao = $_REQUEST['associacao'] != "" ? new Associacao($_REQUEST['associacao']) : null;
        $graduacao = $_REQUEST['graduacao'] != "" ? new Graduacao($_REQUEST['graduacao']) : null;
        $pessoa = new Pessoa();
        
        if($this->recuperaPorIdPessoa($_REQUEST['id'])){
           $_SESSION['fmj.mensagem'] = 44;
           return false; 
        }else{               
            $pessoa->getById($_REQUEST['id']);
            $pessoa->nome =  $_REQUEST['nome'];
            $pessoa->sobrenome = $_REQUEST['sobrenome'];
            $pessoa->nomeMeio = $_REQUEST['nomeMeio'];
            $pessoa->nacionalidade = $_REQUEST['nacionalidade'];
            $pessoa->naturalidade = $cidadeNascimento;
            $pessoa->email = $_REQUEST['email'];
            $pessoa->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
            $pessoa->sexo = $_REQUEST['sexo'];
            $pessoa->cpf = $strCPF;
            $pessoa->telCelular = $this->limpaDigitos($_REQUEST['telefoneCel']);
            $pessoa->telResidencial = $this->limpaDigitos($_REQUEST['telefoneRes']);
            $pessoa->endereco = $_REQUEST['endereco'];
            $pessoa->bairro = $_REQUEST['bairro'];
            $pessoa->cidade = $cidadeEndereco;
            $pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);             
            $pessoa -> foto = "pessoa.png";
			$pessoa ->bitVerificado = 1;			
			$pessoa ->filiacaoPai = $_REQUEST['filiacaoPai'];
			$pessoa ->filiacaoMae = $_REQUEST['filiacaoMae'];
			$pessoa ->rg = $_REQUEST['rg'];
			$pessoa ->rgOrgaoExpedidor = $_REQUEST['rgOrgaoExpedidor'];
			$pessoa ->rgDataExp = $this->convdata($_REQUEST['rgDataExp'], "ntm");
			$pessoa ->passaporte = $_REQUEST['passaporte'];
			$pessoa ->passaporteDataVal = $this->convdata($_REQUEST['passaporteDataVal'], "ntm");
			$pessoa ->passaporteOrgao = $_REQUEST['passaporteOrgao'];
			$pessoa ->passaporteDataExp = $this->convdata($_REQUEST['passaporteDataExp'], "ntm");		
			$pessoa ->vacinas = $_REQUEST['vacinas'];
			$pessoa ->webSite = $_REQUEST['webSite'];
			$pessoa ->midiaSocial = $_REQUEST['midiaSocial'];
			$pessoa ->telComercial  = $this->limpaDigitos($_REQUEST['telefoneCom']);			
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $pessoa -> foto = $nomefoto;
            }
            $idPessoa = $pessoa->save();   
            
             /*if($strCPF == ""){
                $pessoa->cpf = $idPessoa;
                $idPessoa = $pessoa->save();    
            }*/
                     
            //salva o atleta
            $this->id = $idPessoa;
            $this->numeroFemeju = $this->getProximoNumero();
            $this->dataEmissaoCarteira = $this->convdata($_REQUEST['dataEmissaoCarteira'], "ntm");
            $this->dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'], "ntm");
            $this->registroConfederacao = $_REQUEST['registroConf'];
            $this->ativo = isset($_REQUEST['ativo'])?$_REQUEST['ativo']:"1";
            $this->associacao = $associacao;
            $this->graduacao = $graduacao;
            $this->pessoa = $pessoa;
			$this->bitArbitro = isset($_REQUEST['bitArbitro'])?$_REQUEST['bitArbitro']:"0";
			$this->bitAtleta = isset($_REQUEST['bitAtleta'])?$_REQUEST['bitAtleta']:"1";
			$this->bitTecnico = isset($_REQUEST['bitTecnico'])?$_REQUEST['bitTecnico']:"0";
            $this->observacoes = $_REQUEST['observacoes'];
            $this->save();
            
            //gravar no historico da graduacao a primeira graduacao
            if($graduacao != null){
            $histGrad = new HistoricoGraduacao();
            $histGrad->data = $this->convdata($_REQUEST['dataGraduacao'],"ntm");
            $histGrad->atleta = $this;
            $histGrad->graduacao = $graduacao;
            $histGrad->save();
            }
            
            
            $_SESSION['fmj.mensagem'] = 41;
            return true;
            }
        }
        
        
        function Alterar() {
        $this->getById($_REQUEST['id']);
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $associacao = $_REQUEST['associacao'] != "" ? new Associacao($_REQUEST['associacao']) : null;
        $graduacao = $_REQUEST['graduacao'] != "" ? new Graduacao($_REQUEST['graduacao']) : null;
        $pessoa = new Pessoa();
                      
            $pessoa->getById($this->pessoa->id);
            $pessoa->nome =  $_REQUEST['nome'];
            $pessoa->sobrenome = $_REQUEST['sobrenome'];
            $pessoa->nomeMeio = $_REQUEST['nomeMeio'];
            $pessoa->nacionalidade = $_REQUEST['nacionalidade'];
            $pessoa->naturalidade = $cidadeNascimento;
            $pessoa->email = $_REQUEST['email'];
            $pessoa->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
            $pessoa->sexo = $_REQUEST['sexo'];
            if($strCPF != "" && strlen($strCPF) >= 11){
                $pessoa->cpf = $strCPF;    
            }else{
                $pessoa->cpf = $this->id;
            }
            $pessoa->telCelular = $this->limpaDigitos($_REQUEST['telefoneCel']);
            $pessoa->telResidencial = $this->limpaDigitos($_REQUEST['telefoneRes']);
            $pessoa->endereco = $_REQUEST['endereco'];
            $pessoa->bairro = $_REQUEST['bairro'];
            $pessoa->cidade = $cidadeEndereco;
            $pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);        
            $pessoa ->filiacaoPai = $_REQUEST['filiacaoPai'];
			$pessoa ->filiacaoMae = $_REQUEST['filiacaoMae'];
			$pessoa ->rg = $_REQUEST['rg'];
			$pessoa ->rgOrgaoExpedidor = $_REQUEST['rgOrgaoExpedidor'];
			$pessoa ->rgDataExp = $this->convdata($_REQUEST['rgDataExp'], "ntm");
			$pessoa ->passaporte = $_REQUEST['passaporte'];
			$pessoa ->passaporteDataVal = $this->convdata($_REQUEST['passaporteDataVal'], "ntm");
			$pessoa ->passaporteOrgao = $_REQUEST['passaporteOrgao'];
			$pessoa ->passaporteDataExp = $this->convdata($_REQUEST['passaporteDataExp'], "ntm");		
			$pessoa ->vacinas = $_REQUEST['vacinas'];
			$pessoa ->webSite = $_REQUEST['webSite'];
			$pessoa ->midiaSocial = $_REQUEST['midiaSocial'];
			$pessoa ->telComercial  = $this->limpaDigitos($_REQUEST['telefoneCom']);	
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            if ($pessoa -> foto != "pessoa.png")
                $this -> apagaImagem($pessoa -> foto, "img/pessoas/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $pessoa -> foto = $nomefoto;
            }
            $idPessoa = $pessoa->save();            
            //salva o atleta
            $this->dataEmissaoCarteira = $this->convdata($_REQUEST['dataEmissaoCarteira'], "ntm");
            $this->dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'], "ntm");
            $this->registroConfederacao = $_REQUEST['registroConf'];
            $this->ativo = isset($_REQUEST['ativo'])?$_REQUEST['ativo']:"1";
			$this->bitArbitro = isset($_REQUEST['bitArbitro'])?$_REQUEST['bitArbitro']:"0";
			$this->bitAtleta = isset($_REQUEST['bitAtleta'])?$_REQUEST['bitAtleta']:"1";
			$this->bitTecnico = isset($_REQUEST['bitTecnico'])?$_REQUEST['bitTecnico']:"0";
            $this->observacoes = $_REQUEST['observacoes'];
            $this->associacao = $associacao;
            $this->graduacao = $graduacao;
            $this->pessoa = $pessoa;
			
            $this->save();
            $_SESSION['fmj.mensagem'] = 42;
            return true;
            
        }
function IncluirPortal() {
       $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $associacao = $_REQUEST['associacao'] != "" ? new Associacao($_REQUEST['associacao']) : null;
        $graduacao = $_REQUEST['graduacao'] != "" ? new Graduacao($_REQUEST['graduacao']) : null;
        $pessoa = new Pessoa();
            
            $pessoa->nome =  $_REQUEST['nome'];
            $pessoa->sobrenome = $_REQUEST['sobrenome'];
            $pessoa->nomeMeio = $_REQUEST['nomeMeio'];
            $pessoa->nacionalidade = $_REQUEST['nacionalidade'];
            $pessoa->naturalidade = $cidadeNascimento;
            $pessoa->email = $_REQUEST['email'];
            $pessoa->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
            $pessoa->sexo = $_REQUEST['sexo'];
            $pessoa->cpf = $strCPF;
            $pessoa->telCelular = $this->limpaDigitos($_REQUEST['telefoneCel']);
            $pessoa->telResidencial = $this->limpaDigitos($_REQUEST['telefoneRes']);
            $pessoa->endereco = $_REQUEST['endereco'];
            $pessoa->bairro = $_REQUEST['bairro'];
            $pessoa->cidade = $cidadeEndereco;
            $pessoa->cep = $this->limpaDigitos($_REQUEST['cep']);             
            $pessoa -> foto = "pessoa.png";
			$pessoa ->bitVerificado = 0;			
			$pessoa ->filiacaoPai = $_REQUEST['filiacaoPai'];
			$pessoa ->filiacaoMae = $_REQUEST['filiacaoMae'];
			$pessoa ->rg = $_REQUEST['rg'];
			$pessoa ->rgOrgaoExpedidor = $_REQUEST['rgOrgaoExpedidor'];
			$pessoa ->rgDataExp = $this->convdata($_REQUEST['rgDataExp'], "ntm");
			$pessoa ->passaporte = $_REQUEST['passaporte'];
			$pessoa ->passaporteDataVal = $this->convdata($_REQUEST['passaporteDataVal'], "ntm");
			$pessoa ->passaporteOrgao = $_REQUEST['passaporteOrgao'];
			$pessoa ->passaporteDataExp = $this->convdata($_REQUEST['passaporteDataExp'], "ntm");		
			$pessoa ->vacinas = $_REQUEST['vacinas'];
			$pessoa ->webSite = $_REQUEST['webSite'];
			$pessoa ->midiaSocial = $_REQUEST['midiaSocial'];
			$pessoa ->telComercial  = $this->limpaDigitos($_REQUEST['telefoneCom']);
			if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $pessoa -> foto = $nomefoto;
            }
            $idPessoa = $pessoa->save(); 
            if($strCPF == ""){
                $pessoa->cpf = $idPessoa;
                $idPessoa = $pessoa->save();    
            }        
            //salva o atleta
            $this->id = $idPessoa;
            $this->dataEmissaoCarteira = $this->convdata($_REQUEST['dataEmissaoCarteira'], "ntm");
            $this->dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'], "ntm");
            $this->registroConfederacao = $_REQUEST['registroConf'];
            $this->ativo = 0;
			$this->numeroFemeju = NULL;
            $this->associacao = $associacao;
            $this->graduacao = $graduacao;
            $this->pessoa = $pessoa;
			$this->bitArbitro = isset($_REQUEST['bitArbitro'])?$_REQUEST['bitArbitro']:"0";
			$this->bitAtleta = isset($_REQUEST['bitAtleta'])?$_REQUEST['bitAtleta']:"1";
			$this->bitTecnico = isset($_REQUEST['bitTecnico'])?$_REQUEST['bitTecnico']:"0";
            $this->observacoes = $_REQUEST['observacoes'];
            $this->save();               
            //gravar no historico da graduacao a primeira graduacao
            if($graduacao != null){
            $histGrad = new HistoricoGraduacao();
            $histGrad->data = $this->convdata($_REQUEST['dataGraduacao'],"ntm");
            $histGrad->atleta = $this;
            $histGrad->graduacao = $graduacao;
            $histGrad->save();
            }
            $_SESSION['fmj.mensagem'] = 41;
            return true;
            
    }
function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 43;
            if ($this -> pessoa ->foto != "")
                $this -> apagaImagem($this -> pessoa ->foto, "img/pessoas/");
            $pessoa = new Pessoa();
            if(!$pessoa->delete($this->pessoa->id)){
                $_SESSION['fmj.mensagem'] = 45;
            }
           
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
}
?>