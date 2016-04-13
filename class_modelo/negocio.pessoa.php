<?php
class Pessoa extends Persistencia {
		const TABELA = "fmj_pessoa";
	   var $nome;
        var $sobrenome;
        var $nomeMeio;
        var $endereco;
        var $bairro;
        var $cidade = null;
        var $cep;
        var $telCelular;
        var $telResidencial;
        var $email;
        var $dataNascimento;
        var $foto;
        var $cpf;
		var $nacionalidade;
		var $sexo;
		var $bitVerificado;
		var $naturalidade = null;		
		var $filiacaoPai;
		var $filiacaoMae;
		var $rg;
		var $rgOrgaoExpedidor;
		var $rgDataExp;
		var $passaporte;
		var $passaporteDataVal;
		var $passaporteOrgao;
		var $passaporteDataExp;			
		var $vacinas;
		var $webSite;
		var $midiaSocial;
		var $telComercial;
        
        
        function mesclar($arrayPessoas, $idManter){
            //monta a lista de usuarios sem o usuario que vai manter
            $lista = "0";
            foreach ($arrayPessoas as $key => $value) {
                if($value != $idManter && $value != "0")
                    $lista .= ",".$value;
            }
            
            //migra as diretorias responsavel
            $sql = "update fmj_diretoria set id = $idManter where idUsuarioResponsavel in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            //migra as associacoes responsavel
            $sql = "update ".Associacao::TABELA." set idResponsavel = $idManter where idResponsavel in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            //deleta os historicos de graduacao de atletas a ser apagados
            $sql = "delete from fmj_historico_graduacao where idAtleta in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            //migra as inscricoes de competicoes dos atletas para o mantido
            $sql = "update fmj_inscricao_competicao set idAtleta = $idManter where idAtleta in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            //migra as logs de acesso do sistema
            $sql = "update fmj_log set idusuario = $idManter where idusuario in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            //migra os itens de pagamentos relacionados ao atletas
            $sql = "update fmj_pagamento_item set idAtleta = $idManter where idAtleta in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            
            
            
            
            //migra os usuarios
            $objUser = new Usuario();
            if($objUser->getById($idManter)){
                //se a pessoa a ser mantido ja for usuario
                $sql = "delete from ".Usuario::TABELA." where id in(".$lista.")";
                $this->DAO_ExecutarDelete($sql);    
            }else{
                //se não for usuário
                $sql = "select u.* from ".Usuario::TABELA." u where id in(".$lista.")";
                $rsUsers = $objUser->getSQL($sql);
                $primeiro = 0;
                foreach ($rsUsers as $key => $user) {
                    if($primeiro == 0){
                        $sql = "update ".Usuario::TABELA." set id = $idManter where id = ".$user->id;
                        $this->DAO_ExecutarDelete($sql);
                    }else{
                        $sql = "delete from ".Usuario::TABELA." where id = ".$user->id;
                        $this->DAO_ExecutarDelete($sql);        
                    }
                    $primeiro++;
                }
            }
            
            
            //migra os atletas
            $objAtleta = new Atleta();
            if($objAtleta->getById($idManter)){
                //se a pessoa a ser mantido ja for atleta
                $sql = "delete from ".Anuidade::TABELA." where idAtleta in(".$lista.")";
                $this->DAO_ExecutarDelete($sql);
                                
                $sql = "delete from ".Atleta::TABELA." where id in(".$lista.")";
                $this->DAO_ExecutarDelete($sql);    
            }else{
                //se não for atleta
                $sql = "select u.* from ".Atleta::TABELA." u where id in(".$lista.")";
                $rsUsers = $objAtleta->getSQL($sql);
                $primeiro = 0;
                foreach ($rsUsers as $key => $user) {
                    if($primeiro == 0){
                        
                        $sql = "update ".Anuidade::TABELA." set idAtleta = $idManter where id = ".$user->id;
                        $this->DAO_ExecutarDelete($sql);
                        $sql = "update ".Atleta::TABELA." set id = $idManter where id = ".$user->id;
                        $this->DAO_ExecutarDelete($sql);
                    }else{
                        $sql = "delete from ".Anuidade::TABELA." where idAtleta = ".$user->id;
                        $this->DAO_ExecutarDelete($sql);
                        $sql = "delete from ".Atleta::TABELA." where id in(".$lista.")";
                        $this->DAO_ExecutarDelete($sql);            
                    }
                    $primeiro++;
                }
            }
            
            //deleta as pessoas
            $sql = "delete from ".$this::TABELA." where id in(".$lista.")";
            $this->DAO_ExecutarDelete($sql);
            return true;
        }
        
        
        
        function getNomeCompleto(){
            return $this->nome.(strlen($this->nomeMeio) > 0 ? " ".$this->nomeMeio:"").(strlen($this->sobrenome) > 0 ? " ".$this->sobrenome:"");
        }
        
        function getPessoasNaoAtleta($cpf){
            $sql = "select p.* from ".$this::TABELA." p left outer join ".Atleta::TABELA." a on a.id = p.id where p.cpf like '$cpf%' and a.id is null order by nome asc";
            return $this->getSQL($sql);
        }
        
        function gerarArraySacado($idPessoa){
            $this->getById($idPessoa);
            $arrayResp = array();
            $arrayResp['nome'] = $this->nome." ".$this->nomeMeio." ".$this->sobrenome;
            $arrayResp['cpf'] = $this->cpf;
            $arrayResp['endereco'] = $this->endereco;
            $arrayResp['bairro'] = $this->bairro;
            $arrayResp['cidade'] = $this->cidade != Null ? $this->cidade->nome : "Brasília";
            $arrayResp['uf'] = $this->cidade != Null ? $this->cidade->uf->uf : "DF";
            return $arrayResp;
        }
        
        function pesquisarTotal($nome = "") {
        $sql = "select count(a.id) as total from ".$this::TABELA." a where 1 = 1 ";
         
        if ($nome != "")
            $sql .= " and ( a.nome like '%$nome%' or a.nomeMeio like '%$nome%' or a.sobrenome like '%$nome%' or a.endereco like '%$nome%' or a.bairro like '%$nome%')";
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $nome = "") {

        $sql = "select a.* from ".$this::TABELA." a where 1 = 1 ";
         
        if ($nome != "")
            $sql .= " and ( a.nome like '%$nome%' or a.nomeMeio like '%$nome%' or a.sobrenome like '%$nome%' or a.endereco like '%$nome%' or a.bairro like '%$nome%')";
        
        $sql .= "  order by a.nome desc limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    
    function Incluir() {
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
            $this->nome =  $_REQUEST['nome'];
            $this->sobrenome = $_REQUEST['sobrenome'];
            $this->nomeMeio = $_REQUEST['nomeMeio'];
            $this->nacionalidade = $_REQUEST['nacionalidade'];
            $this->naturalidade = $cidadeNascimento;
            $this->email = $_REQUEST['email'];
            $this->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
            $this->sexo = $_REQUEST['sexo'];
            $this->cpf = $strCPF;
            $this->telCelular = $this->limpaDigitos($_REQUEST['telefoneCel']);
            $this->telResidencial = $this->limpaDigitos($_REQUEST['telefoneRes']);
            $this->endereco = $_REQUEST['endereco'];
            $this->bairro = $_REQUEST['bairro'];
            $this->cidade = $cidadeEndereco;
            $this->cep = $this->limpaDigitos($_REQUEST['cep']);             
            $this-> foto = "pessoa.png";
            $this->bitVerificado = 1;            
            $this->filiacaoPai = $_REQUEST['filiacaoPai'];
            $this->filiacaoMae = $_REQUEST['filiacaoMae'];
            $this->rg = $_REQUEST['rg'];
            $this->rgOrgaoExpedidor = $_REQUEST['rgOrgaoExpedidor'];
            $this->rgDataExp = $this->convdata($_REQUEST['rgDataExp'], "ntm");
            $this->passaporte = $_REQUEST['passaporte'];
            $this->passaporteDataVal = $this->convdata($_REQUEST['passaporteDataVal'], "ntm");
            $this->passaporteOrgao = $_REQUEST['passaporteOrgao'];
            $this->passaporteDataExp = $this->convdata($_REQUEST['passaporteDataExp'], "ntm");       
            $this->vacinas = $_REQUEST['vacinas'];
            $this->webSite = $_REQUEST['webSite'];
            $this->midiaSocial = $_REQUEST['midiaSocial'];
            $this->telComercial  = $this->limpaDigitos($_REQUEST['telefoneCom']);            
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $this-> foto = $nomefoto;
            }
            $idPessoa = $this->save(); 
            
            if($strCPF == ""){
                $this->cpf = $idPessoa;
                $idPessoa = $this->save();    
            }
                       
            
            $_SESSION['fmj.mensagem'] = 71;
            return true;
            }
        
        
        
        function Alterar() {
        $this->getById($_REQUEST['id']);
        $strCPF = $this -> limpaCpf($_REQUEST['cpf']);
        $cidadeNascimento = $_REQUEST['naturalidade'] != "" ? new Cidade($_REQUEST['naturalidade']) : null;
        $cidadeEndereco = $_REQUEST['cidade'] != "" ? new Cidade($_REQUEST['cidade']) : null;
        
                      
            $this->nome =  $_REQUEST['nome'];
            $this->sobrenome = $_REQUEST['sobrenome'];
            $this->nomeMeio = $_REQUEST['nomeMeio'];
            $this->nacionalidade = $_REQUEST['nacionalidade'];
            $this->naturalidade = $cidadeNascimento;
            $this->email = $_REQUEST['email'];
            $this->dataNascimento = $this->convdata($_REQUEST['dataNascimento'], "ntm");
            $this->sexo = $_REQUEST['sexo'];
            if($strCPF != "" && strlen($strCPF) >= 11){
                $this->cpf = $strCPF;    
            }else{
                $this->cpf = $this->id;
            }
            
            $this->telCelular = $this->limpaDigitos($_REQUEST['telefoneCel']);
            $this->telResidencial = $this->limpaDigitos($_REQUEST['telefoneRes']);
            $this->endereco = $_REQUEST['endereco'];
            $this->bairro = $_REQUEST['bairro'];
            $this->cidade = $cidadeEndereco;
            $this->cep = $this->limpaDigitos($_REQUEST['cep']);             
            $this->bitVerificado = 1;            
            $this->filiacaoPai = $_REQUEST['filiacaoPai'];
            $this->filiacaoMae = $_REQUEST['filiacaoMae'];
            $this->rg = $_REQUEST['rg'];
            $this->rgOrgaoExpedidor = $_REQUEST['rgOrgaoExpedidor'];
            $this->rgDataExp = $this->convdata($_REQUEST['rgDataExp'], "ntm");
            $this->passaporte = $_REQUEST['passaporte'];
            $this->passaporteDataVal = $this->convdata($_REQUEST['passaporteDataVal'], "ntm");
            $this->passaporteOrgao = $_REQUEST['passaporteOrgao'];
            $this->passaporteDataExp = $this->convdata($_REQUEST['passaporteDataExp'], "ntm");       
            $this->vacinas = $_REQUEST['vacinas'];
            $this->webSite = $_REQUEST['webSite'];
            $this->midiaSocial = $_REQUEST['midiaSocial'];
            $this->telComercial  = $this->limpaDigitos($_REQUEST['telefoneCom']);      
            if ($_FILES['foto']['name'] != "") {
            //incluir imagem se ouver
            if ($this -> foto != "pessoa.png")
                $this -> apagaImagem($this -> foto, "img/pessoas/");
            $nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/pessoas/");
            $this -> salvarFoto($_FILES['foto'], $nomefoto, "img/pessoas/");
            $this -> foto = $nomefoto;
            }
            $idPessoa = $this->save();            
            $this->save();
            $_SESSION['fmj.mensagem'] = 72;
            return true;
            
        }

function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 73;
            if ($this ->foto != "")
                $this -> apagaImagem($this ->foto, "img/pessoas/");
            
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }

function ConsultaCPFExistente($cpf, $idExclusao = "0") {
        $sql = "select * from fmj_pessoa where cpf = '$cpf' and id != $idExclusao";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
            $this->getById($rs[0]->id);
            return true;
        }else
            return false;
    }
function ConsultaNomesPessoa($nome,$nomeMeio,$sobrenome, $idExclusao = "0") {
        $sql = "select * from fmj_pessoa where nome like '".utf8_decode($nome)."' and sobrenome like '".utf8_decode($sobrenome)."' and nomeMeio like '".utf8_decode($nomeMeio)."' and id != $idExclusao";
        $rs = $this->getSQL($sql);
        if(count($rs) > 0){
            return true;
        }else
            return false;
    }

}
?>