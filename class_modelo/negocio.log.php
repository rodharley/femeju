<?php
class Log extends Persistencia{
	var $usuario = NULL;
	var $ip;
	var $navegador;
	var $url;	
	var $data;	
	var $texto;
	
	
	
	public function gerarLog($texto){
		$this->id = NULL;
		$this->navegador = $_SERVER['HTTP_USER_AGENT'];
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->url = $_SERVER['REQUEST_URI'];
		$this->data = date("Y-m-d H:i:s");
		if(isset($_SESSION['grc.userId'])){
		$this->usuario = new Usuario($_SESSION['grc.userId']);
		}else{
		$this->usuario = NULL;	
		}
        
		$this->texto =$texto;
		$this->save();
	}
	
	
	public function pesquisa($texto = "",$empresa="",$condominio="",$usuario="",$periodo){
			
		$sql = "select  l.* from grc_log l inner join grc_usuario u on u.id = l.idusuario where 1 = 1 ";
		if($texto != ""){
			$sql .= " and l.texto like '%$texto%'";			
		}
		if($empresa != ""){
			$sql .= " and u.empresa = ".$empresa;
		}
		if($condominio != ""){
			$sql .= " and u.condominio = ".$condominio;
		}
		if($usuario != ""){
			$sql .= " and u.id = ".$usuario;
		}
		if($periodo != ""){
			$arrayData = explode("-", str_replace(" ", "",$periodo));
			$sql .= " and l.data between '".$this->convdata($arrayData[0],"ntm")." 00:00:00' and '".$this->convdata($arrayData[1],"ntm")." 23:59:59' ";
		}
		$sql .= " order by data desc";
		return $this->getSQL($sql);
	}
		
	}
?>