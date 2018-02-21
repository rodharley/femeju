<?php
class Associacao extends Persistencia {
    const TABELA = "fmj_associacao";
    var $nome;
    var $razaoSocial;
    var $sigla;
    var $cnpj;
    var $identificacao;
    var $descricao;
    var $logomarca;
    var $dataFiliacao;
    var $endereco;
    var $bairro;
    var $cidade = NULL;
    var $cep;
    var $responsavel = NULL;
    var $telefone1;
    var $telefone2;
    var $email;
    var $webSite;
    var $midiaSocial;
    var $ativo;
    var $fotos = array();

public function listaAtivas($ordem = ""){
	if($ordem != "")	
	$arrayOrdem  = array($ordem=>"asc");
	else {
		$arrayOrdem = array();
	}
	
    return $this->getRows(0,9999,$arrayOrdem,array("ativo"=>"=1"));
}
public function listaPorResponsavelAtivas($responsavel){
    return $this->getRows(0,9999,array(),array("ativo"=>"=1","responsavel"=>"=$responsavel"));
}

function pesquisarTotal($nome = "",$sigla = "",$ativo = "") {
        $sql = "select count(id) as total from ".$this::TABELA." where 1 = 1 ";
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo"; 
        if ($nome != "")
            $sql .= " and ( nome like '%$nome%' or razaoSocial like '%$nome%' or endereco like '%$nome%' or bairro like '%$nome%')";
        if ($sigla != "")
            $sql .= " and ( sigla like '%$sigla%')";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $nome = "",$sigla = "",$ativo = "") {

        $sql = "select * from ".$this::TABELA." where 1 = 1 ";
        
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo";
        
        if ($nome != "")
            $sql .= " and ( nome like '%$nome%' or razaoSocial like '%$nome%' or endereco like '%$nome%' or bairro like '%$nome%')";
        
        if ($sigla != "")
            $sql .= " and ( sigla like '%$sigla%')";
        
        $sql .= "  order by nome limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    
    
    function Incluir() {
        $this -> nome = $_REQUEST['nome'];
        $this -> descricao = $_REQUEST['descricao'];
        $this -> razaoSocial = $_REQUEST['razaoSocial'];
        $this->ativo = $_REQUEST['ativo'];
        $this -> logomarca = "";
        $this -> dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'],"ntm")." ".date("H:i:s");
        $this->sigla = $_REQUEST['sigla'];
        $this->identificacao = $_REQUEST['identificacao'];
        $this->cnpj = $this->limpaDigitos($_REQUEST['cnpj']);
        $this->endereco = $_REQUEST['endereco'];
        $this->bairro = $_REQUEST['bairro'];
        $this->cep = $_REQUEST['cep'];
        $this->cidade = new Cidade($_REQUEST['cidade']);
        $this->email = $_REQUEST['email_a'];
        $this->webSite = $_REQUEST['website'];
        $this->midiaSocial = $_REQUEST['midiaSocial'];
        $this->telefone1 = $this->limpaDigitos($_REQUEST['telefone1']);
        $this->telefone2 = $this->limpaDigitos($_REQUEST['telefone2']);
        $this->logomarca = "nologo.png";
        if ($_FILES['logomarca']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['logomarca']['name'], "img/associacoes/");
            $this -> uploadImagem($_FILES['logomarca'], $nomefoto, "img/associacoes/");
            $this -> logomarca = $nomefoto;
        }
        $objPessoa = new Pessoa();
        $objUser =new Usuario();
        $objPerfil = new Perfil();
        $objPerfil -> id = 3;        
        if($_REQUEST['idResponsavel'] != "0"){
            $objUser->id = $_REQUEST['idResponsavel'];
        }else{
            //novo responsavel
            $strCPF =$this->limpaDigitos($_REQUEST['cpf_responsavel']);
            $objPessoa->ConsultaCPFExistente($strCPF);
            $objUser -> perfil = $objPerfil;
            $objPessoa->nome = $_REQUEST['nome_responsavel'];
            $objPessoa->sobrenome =  $_REQUEST['sobrenome_responsavel'];
            $objPessoa->nomeMeio =  $_REQUEST['nomemeio_responsavel'];
            $objPessoa->endereco = $_REQUEST['endereco_responsavel'];
            $objPessoa->bairro = $_REQUEST['bairro_responsavel'];
            $objPessoa->cep = $_REQUEST['cep_responsavel'];
            $objPessoa->cpf = $strCPF;
            $objPessoa->email =  $_REQUEST['email'];
            $objPessoa->cidade = new Cidade($_REQUEST['cidade_responsavel']);
            $objPessoa->telCelular =  $this->limpaDigitos($_REQUEST['celular_responsavel']);
            $objPessoa->bitVerificado = 1;
            $objPessoa->foto = 'pessoa.png';
            $id = $objPessoa->save();     
            $objUser->id = $id;
            $objUser -> senha = "";
            $objUser -> ativo = 0;
			$objUser -> responsavel = 1;
            $objUser -> pessoa = $objPessoa;
            $objUser -> save();
            $objUser->id = $id;
            $email = new Email();
            $email->enviarEmailNovoUsuario($objPessoa->nome,$objPessoa->email,$objUser->id);
        }
        
        $this->responsavel = $objUser;        
        $idAssociacao = $this -> save();        
        
        if($_FILES['fotos']['name'][0] != ""){
            
        foreach ($_FILES['fotos']['name'] as $key => $value) {
                $foto = new AssociacaoFoto();
                //incluir imagem se ouver
                $nomefoto = $this -> retornaNomeUnico($_FILES['fotos']['name'][$key], "img/associacoes/");
                $this -> uploadImagemArray($_FILES['fotos'],$key, $nomefoto, "img/associacoes/");
                $foto -> imagem = $nomefoto;
                $foto -> associacao = $this;
                $foto ->save();
        }
            
        }
        
    }
    
     function Alterar() {
        $this -> getById($_REQUEST['id']);        
        $this -> nome = $_REQUEST['nome'];
        $this -> descricao = $_REQUEST['descricao'];
        $this -> razaoSocial = $_REQUEST['razaoSocial'];
        $this->ativo = $_REQUEST['ativo'];
        $this -> dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'],"ntm")." ".date("H:i:s");
        $this->sigla = $_REQUEST['sigla'];
        $this->identificacao = $_REQUEST['identificacao'];
        $this->cnpj = $this->limpaDigitos($_REQUEST['cnpj']);
        $this->endereco = $_REQUEST['endereco'];
        $this->bairro = $_REQUEST['bairro'];
        $this->cep = $_REQUEST['cep'];
        $this->cidade = new Cidade($_REQUEST['cidade']);
        $this->email = $_REQUEST['email_a'];
        $this->webSite = $_REQUEST['website'];
        $this->midiaSocial = $_REQUEST['midiaSocial'];
        $this->telefone1 = $this->limpaDigitos($_REQUEST['telefone1']);
        $this->telefone2 = $this->limpaDigitos($_REQUEST['telefone2']);
         if ($_FILES['logomarca']['name'] != "") {
            if ($this -> logomarca != "nologo.png")
                $this -> apagaImagem($this -> logomarca, "img/associacoes/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['logomarca']['name'], "img/associacoes/");
            $this -> uploadImagem($_FILES['logomarca'], $nomefoto, "img/associacoes/");
            $this -> logomarca = $nomefoto;
        }
         
         if($_FILES['fotos']['name'][0] != ""){
            
        foreach ($_FILES['fotos']['name'] as $key => $value) {            
                $foto = new AssociacaoFoto();
                //incluir imagem se ouver
                $nomefoto = $this -> retornaNomeUnico($_FILES['fotos']['name'][$key], "img/associacoes/");
                $this -> uploadImagemArray($_FILES['fotos'],$key, $nomefoto, "img/associacoes/");
                $foto -> imagem = $nomefoto;
                $foto -> associacao = $this;
                $foto ->save();
        }
            
        }


        $objPessoa = new Pessoa();
        $objUser =new Usuario();
        $objPerfil = new Perfil();
        $objPerfil -> id = 3;
        
        if($_REQUEST['idResponsavel'] != "0"){
             $objUser->id = $_REQUEST['idResponsavel'];
        }else{            
            //novo responsavel
            $strCPF =$this->limpaDigitos($_REQUEST['cpf_responsavel']);
            $objPessoa->ConsultaCPFExistente($strCPF);             
            $objUser -> perfil = $objPerfil;
            $objPessoa->nome = $_REQUEST['nome_responsavel'];
            $objPessoa->sobrenome =  $_REQUEST['sobrenome_responsavel'];
            $objPessoa->email =  $_REQUEST['email'];
            $objPessoa->telCelular =  $this->limpaDigitos($_REQUEST['celular_responsavel']);
            $objPessoa->nomeMeio =  $_REQUEST['nomemeio_responsavel'];
            $objPessoa->endereco = $_REQUEST['endereco_responsavel'];
            $objPessoa->bairro = $_REQUEST['bairro_responsavel'];
            $objPessoa->cep = $_REQUEST['cep_responsavel'];
            $objPessoa->cpf = $strCPF;
            $objPessoa->email =  $_REQUEST['email'];
            $objPessoa->cidade = new Cidade($_REQUEST['cidade_responsavel']);
            $objPessoa->foto = 'pessoa.png';
            $objPessoa->bitVerificado = 1;
            $id = $objPessoa->save();     
            $objUser->id = $id;
            $objUser -> senha = "";
            $objUser -> ativo = 0;
			$objUser -> responsavel = 1;
            $objUser -> pessoa = $objPessoa;
            $objUser -> save();
            $objUser->id = $id;
            $email = new Email();
            $email->enviarEmailNovoUsuario($objPessoa->nome,$objPessoa->email,$objUser->id);
        }
        
        $this->responsavel = $objUser;        
        $idAssociacao = $this -> save();       
        
        
         
         return $this -> save();
         
     }

function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 39;
            if ($this -> logomarca != "nologo.png")
                $this -> apagaImagem($this -> logomarca, "img/associacoes/");
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
   
}
?>