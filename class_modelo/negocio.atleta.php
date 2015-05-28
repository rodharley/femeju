<?php
class Atleta extends Persistencia {
   var $nome;
        var $sobrenome;
        var $email;
        var $sexo;
        var $nomePai;
        var $nomeMae;
        var $rg;
        var $cpf;
        var $rgEmissor;      
        var $logradouro;
        var $bairro;
        var $cep;
        var $telResidencial;
        var $telComercial;
        var $telCelular;
        var $foto;
        var $situacaoFEMEJU;
        var $situacaoCBJ;
        var $einstrutor;
        var $rgData;
        var $dataNascimento;
        var $dataInscricao;
        var $cidadeNascimento = null;
        var $cidadeEndereco = null;
        var $academia = null;
        var $instrutor = null;
        
   public function listaTodosInstrutores(){
       return $this->getRows(0,999,array("nome"=>"asc"),array("einstrutor"=>"=1"));
       
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
}
?>