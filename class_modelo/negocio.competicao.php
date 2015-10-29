<?php
class Competicao extends Persistencia {
    var $descricao;
    var $titulo;
    var $dataEvento;    
	var $inscricaoAberta;
    var $tipo;
    
    public function Incluir(){
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = 0;
        return $this->save();
        
    }
}
?>