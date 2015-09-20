<?php
class Pessoa extends Persistencia {
		const TABELA = "fmj_pessoa";
	   var $nome;
        var $sobrenome;
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
		var $naturalidade = null;
}
?>