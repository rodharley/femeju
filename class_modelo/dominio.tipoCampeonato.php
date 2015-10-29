<?php
class TipoCampeonato{
	const FECHADO = 1;
    const ABERTO = 2;
    
    var $id;
    var $descricao;
    
    public function __construct($id = NULL){
        $this->id = $id;
        $this->descricao = $this->getDescricao($id);                
    }
    
    function getDescricao($id){
        switch ($id) {
            case $this::FECHADO:
                return 'Fechado';
                break;
            case $this::ABERTO:
                return 'Aberto';
                break;
            default:
                return '';
                break;
        }
        
    }
}
?>