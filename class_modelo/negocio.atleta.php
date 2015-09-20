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

        $sql = "select * from ".$this::TABELA." a INNER JOIN ".Pessoa::TABELA." p on p.id = a.idPessoa INNER JOIN ".Associacao::TABELA." x on x.id = a.idAssociacao  where 1 = 1 ";
        
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
        $cidadeNascimento = $_REQUEST['cidadeNascimento'] != "" ? new Cidade($_REQUEST['cidadeNascimento']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $academia = $_REQUEST['academia'] != "" ? new Academia($_REQUEST['academia']) : null;
        $instrutor = $_REQUEST['instrutor'] != "" ? new Atleta($_REQUEST['instrutor']) : null;
        
        $this->nome = $_REQUEST['nome'];
        $this->sobrenome = $_REQUEST['sobrenome'];
        $this->email = $_REQUEST['email'];
        $this->sexo = $_REQUEST['sexo'];
        $this->nomePai = $_REQUEST['nomePai'];
        $this->nomeMae = $_REQUEST['nomeMae'];
        $this->rg = $_REQUEST['rg'];
        $this->cpf = $strCPF;
        $this->rgEmissor = $_REQUEST['rgLocal'];
        $this->logradouro = $_REQUEST['localidade'];
        $this->bairro = $_REQUEST['bairro'];
        $this->cep = $_REQUEST['cep'];
        $this->telResidencial = $this->limpaDigitos($_REQUEST['residencial']);
        $this->telComercial = $this->limpaDigitos($_REQUEST['comercial']);
        $this->telCelular = $this->limpaDigitos($_REQUEST['celular']);        
        $this->situacaoFEMEJU = $_REQUEST['femeju'];
        $this->situacaoCBJ = $_REQUEST['cbj'];
        $this->einstrutor = $_REQUEST['einstrutor'];
        $this->rgData = $this->convdata($_REQUEST['rgDataExpedicao'], "ntm");
        $this->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
        $this->dataInscricao = date("Y-m-d");
        $this->cidadeNascimento = $cidadeNascimento;
        $this->cidadeEndereco = $cidadeEndereco;
        $this->academia = $academia;
        $this->instrutor = $instrutor;
        
        $this -> foto = "atleta.png";
        if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/atletas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/atletas/");
            $this -> foto = $nomefoto;
        }     
        
        //$this->conn->connection->autocommit(false);
        $this -> save();        
        //$this->conn->connection->commit();        
        $_SESSION['fmj.mensagem'] = 22;
        header("Location:admin_home-home");
        exit();

    }

function IncluirPortal() {
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['cidadeNascimento'] != "" ? new Cidade($_REQUEST['cidadeNascimento']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        $instrutor = $_REQUEST['instrutor'] != "" ? new Atleta($_REQUEST['instrutor']) : null;        
        
        $this->nome = $_REQUEST['nome'];
        $this->sobrenome = $_REQUEST['sobrenome'];
        $this->email = $_REQUEST['email'];
        $this->sexo = $_REQUEST['sexo'];
        $this->nomePai = $_REQUEST['nomePai'];
        $this->nomeMae = $_REQUEST['nomeMae'];
        $this->rg = $_REQUEST['rg'];
        $this->cpf = $strCPF;
        $this->rgEmissor = $_REQUEST['rgLocal'];
        $this->logradouro = $_REQUEST['localidade'];
        $this->bairro = $_REQUEST['bairro'];
        $this->cep = $_REQUEST['cep'];
        $this->telResidencial = $this->limpaDigitos($_REQUEST['residencial']);
        $this->telComercial = $this->limpaDigitos($_REQUEST['comercial']);
        $this->telCelular = $this->limpaDigitos($_REQUEST['celular']);        
        $this->situacaoFEMEJU = 0;
        $this->situacaoCBJ = 0;
        $this->einstrutor = $_REQUEST['einstrutor'];
        $this->rgData = $this->convdata($_REQUEST['rgDataExpedicao'], "ntm");
        $this->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
        $this->dataInscricao = date("Y-m-d");
        $this->cidadeNascimento = $cidadeNascimento;
        $this->cidadeEndereco = $cidadeEndereco;
        
        //cadastra a academia e o instrutor
        if($_REQUEST['idAcademia'] != "0")
        $academia = new Academia($_REQUEST['idAcademia']);
        else{
            $academia = new Academia();
            $academia->nome = $_REQUEST['nomeAcademia'];
            $academia->registro = $_REQUEST['registroAcademia'];
            $academia->bairro = $_REQUEST['bairroAcademia'];
            $academia->logradouro = $_REQUEST['logradouroAcademia'];
            $academia->cep = $_REQUEST['cepAcademia'];
            $academia->telComercial = $_REQUEST['telefoneAcademia'];
            $academia->cidade = new Cidade($_REQUEST['cidadeAcademia']);
            $academia->save();            
        }
        $this->academia = $academia;
        $this->instrutor = $instrutor;
        
        $this -> foto = "atleta.png";
        if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/atletas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/atletas/");
            $this -> foto = $nomefoto;
        }     
        
        //$this->conn->connection->autocommit(false);
        $this -> save();        
        //$this->conn->connection->commit();        
        $_SESSION['fmj.mensagem'] = 22;
        header("Location:portal_servicos-main");
        exit();

    }
}
?>