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
        
        function getNomeCompleto(){
            return $this->nome.(strlen($this->nomeMeio) > 0 ? " ".$this->nomeMeio:"").(strlen($this->sobrenome) > 0 ? " ".$this->sobrenome:"");
        }
        
        function getPessoasNaoAtleta($nome){
            $sql = "select p.* from ".$this::TABELA." p left outer join ".Atleta::TABELA." a on a.id = p.id where nome like '%$nome%' and a.id is null order by nome asc";
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
}
?>