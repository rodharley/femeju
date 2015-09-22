<?php
class Atleta extends Persistencia {
	const TABELA = "fmj_atleta";
   var $dataFiliacao;   
   var $dataEmissaoCarteira;
   var $registroConfederacao;
   var $ativo;
   var $graduacao = NULL;
   var $associacao = NULL;        
   var $pessoa = NULL;
   
   function recuperaPorIdPessoa($idPessoa) {
        $id = isset($idPessoa) ? $idPessoa == "" ? "0" : $idPessoa  : "0";
        $sql = "select u.* from ".$this::TABELA." u where u.idPessoa = $id";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
           $this->getById($rs[0]->id);      
            return true;
        }else
            return false;
    }
    
	function pesquisarTotal($nome = "",$associacao = "",$ativo = "") {
        $sql = "select count(a.id) as total from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.idPessoa INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao where 1 = 1 ";
        if($ativo != "")
            $sql .= " and a.bitAtivo = $ativo"; 
        if ($nome != "")
            $sql .= " and ( p.nome like '%$nome%' or p.sobrenome like '%$nome%' or p.endereco like '%$nome%' or p.bairro like '%$nome%')";
        if ($associacao != "")
            $sql .= " and ( x.nome like '%$associacao%' or x.sigla like '%$associacao%' )";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $nome = "",$associacao = "",$ativo = "") {

        $sql = "select a.* from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.idPessoa INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao  where 1 = 1 ";
        
        if($ativo != "")
            $sql .= " and a.bitAtivo = $ativo"; 
        if ($nome != "")
            $sql .= " and ( p.nome like '%$nome%' or p.sobrenome like '%$nome%' or p.endereco like '%$nome%' or p.bairro like '%$nome%')";
        if ($associacao != "")
            $sql .= " and ( x.nome like '%$associacao%' or x.sigla like '%$associacao%' )";
        
        $sql .= "  order by p.nome limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
	
    function Incluir() {
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $associacao = $_REQUEST['associacao'] != "" ? new Associacao($_REQUEST['associacao']) : null;
        $graduacao = $_REQUEST['associacao'] != "" ? new Graduacao($_REQUEST['associacao']) : null;
        $pessoa = new Pessoa();
        
        if($this->recuperaPorIdPessoa($_REQUEST['idPessoa'])){
           $_SESSION['fmj.mensagem'] = 44;
           return false; 
        }else{               
            $pessoa->getById($_REQUEST['idPessoa']);
            $pessoa->nome =  $_REQUEST['nome'];
            $pessoa->sobrenome = $_REQUEST['sobrenome'];
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
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $pessoa -> foto = $nomefoto;
            }
            $idPessoa = $pessoa->save();            
            //salva o atleta
            $this->dataEmissaoCarteira = $this->convdata($_REQUEST['dataEmissaoCarteira'], "ntm");
            $this->dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'], "ntm");
            $this->registroConfederacao = $_REQUEST['registroConf'];
            $this->ativo = $_REQUEST['ativo'];
            $this->associacao = $associacao;
            $this->graduacao = $graduacao;
            $this->pessoa = $pessoa;
            $this->save();
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
            
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $pessoa -> foto = $nomefoto;
            }
            $idPessoa = $pessoa->save();            
            //salva o atleta
            $this->dataEmissaoCarteira = $this->convdata($_REQUEST['dataEmissaoCarteira'], "ntm");
            $this->dataFiliacao = $this->convdata($_REQUEST['dataFiliacao'], "ntm");
            $this->registroConfederacao = $_REQUEST['registroConf'];
            $this->ativo = $_REQUEST['ativo'];
            $this->associacao = $associacao;
            $this->graduacao = $graduacao;
            $this->pessoa = $pessoa;
            $this->save();
            $_SESSION['fmj.mensagem'] = 42;
            return true;
            
        }
function IncluirPortal() {
       
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