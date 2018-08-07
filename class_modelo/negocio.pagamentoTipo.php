<?php
class PagamentoTipo extends Persistencia{
	 const BOLETO = "1";
	 const DINHEIRO = "2";
	 const PAYPAL = "3";
	
	var $descricao;
    var $imagem;
    var $arquivo;
	var $ativo;
}
?>