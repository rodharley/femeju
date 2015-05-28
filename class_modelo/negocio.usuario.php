<?php
class Usuario extends Persistencia {
	var $perfil = NULL;	
	var $nome;
	var $senha;
	var $email;
	var $ativo;
	var $cpf;
	var $foto;	
	var $telefone;
	var $celular;
	

	function LogOff() {
		
		//grava a log
				$log = new Log();
				$log->gerarLog("Sair do Sistema");
		unset($_SESSION['fmj.userId']);
		unset($_SESSION['fmj.userNome']);
		unset($_SESSION['fmj.userFoto']);
		unset($_SESSION['fmj.userPerfil']);
		unset($_SESSION['fmj.userPerfilId']);
		unset($_SESSION['fmj.menu']);
	}

	function recuperaTotal($busca = "") {
				$sql = "select count(id) as total from fmj_usuario WHERE 1 = 1 ";
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}


	function recuperaTotalPerfil($idPerfil, $busca = "") {
		
				$sql = "select count(id) as total from fmj_usuario WHERE fmj_perfil_id = $idPerfil";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$rs = $this -> DAO_ExecutarQuery($sql);
		return $this -> DAO_Result($rs, "total", 0);
	}
	
	function listarUsuariosPerfil($idPerfil, $primeiro = 0, $quantidade = 9999, $busca = "") {

		
				$sql = "select * from fmj_usuario where fmj_perfil_id = $idPerfil";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	function listarUsuarios($primeiro = 0, $quantidade = 9999, $busca = "") {

				$sql = "select * from fmj_usuario where 1 = 1";
		
		if ($busca != "")
			$sql .= " and (nome like '$busca%' or cpf like '$busca%')";

		$sql .= "  order by nome limit $primeiro, $quantidade";
		return $this -> getSQL($sql);

	}

	
	function login($login, $senha) {
			
		
		
		if ($this ->recuperaPorLogin($login)) {
			    
			if ($this -> ativo == 1) {
				if ($this -> senha == md5($senha)) {
					$_SESSION['fmj.userId'] = $this -> id;
					$_SESSION['fmj.userNome'] = $this -> nome;
					$_SESSION['fmj.userPerfil'] = $this -> perfil -> descricao;
					$_SESSION['fmj.userFoto'] = $this -> foto;
					$_SESSION['fmj.userPerfilId'] = $this -> perfil -> id;					
					//grava a log
				$log = new Log();
                
				$log->gerarLog("Entrou no Sistema");
					
                    
					//carrega os itens de menu do perfil
					$a = new Acesso();                    
					$lista = $a -> recuperaMenuAcessos($this -> perfil -> id);					
					$_SESSION['fmj.menu'] = "0";					
					foreach ($lista as $key => $acesso) {
						$_SESSION['fmj.menu'] .= "," . $acesso -> menu -> id;
					}
					
					return true;
				} else {
					
					//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, senha inválida");
					
					$_SESSION['fmj.mensagem'] = 2;
					return false;
				}
			} else {
				//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, usuário inativo");
				
				$_SESSION['fmj.mensagem'] = 12;
				return false;
			}
		} else {
			//login invalido
			//grava a log
					$log = new Log();
					$log->gerarLog("Tentativa de Login, Login inválido");
			
			$_SESSION['fmj.mensagem'] = 1;
			return false;
		}

	}

	function EnviarSenha($email) {
		$lista = $this -> recuperaPorEmail($email);
		if (count($lista) > 0) {

			foreach ($lista as $key => $user) {
				$senha = $this -> makePassword(8);
				$user -> senha = md5($senha);
				$objEmail = new Email();
				
				if ($objEmail->enviarEmailNovaSenha($user->nome,$user->email,$senha)) {
					$user -> save();
					$_SESSION['fmj.mensagem'] = 15;
				} else {
					$_SESSION['fmj.mensagem'] = 11;
				}
			}

		} else {
			$_SESSION['fmj.mensagem'] = 1;
		}
	}

	function recuperaPorEmail($email, $idExclusao = "0") {
		$lista = $this -> getRows(0, 20, array(), array("email" => "='" . $email . "'", "id" => "!=" . $idExclusao));
		return $lista;
	}

	function recuperaPorLogin($login, $idExclusao = "0") {
	    $this -> getRow(array("email" => "='" . $login . "'", "id" => "!=" . $idExclusao));
		if ($this -> id != NULL)
			return true;
		else
			return false;
	}

	function Excluir($id) {
	    $this->getById($this -> md5_decrypt($id));
		if($this -> delete($this->id))
		$_SESSION['fmj.mensagem'] = 8;
        else
        $_SESSION['fmj.mensagem'] = 17;
		header("Location:admin_usuario-main");
		exit();
	}
	function Redefinir($idUser){
		$this->getById($this->md5_decrypt($idUser));
		$this -> login = "";
		$this -> senha = "";
		$this -> ativo = 0;
		$this -> save();
		
		$email = new Email();
		$email->enviarEmailRedefinirSenha($this->nome,$this->email,$this->id);
		$_SESSION['fmj.mensagem'] = 10;
		header("Location:admin_usuario-main");
		exit();
	}
	function Incluir() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		$p = new Perfil();
		$p -> id = $_REQUEST['perfil'];
		$this -> perfil = $p;
		//$senha = $_REQUEST['senha'] != "" ? $_REQUEST['senha'] : md5($this -> makePassword(8));
		$this -> nome = $_REQUEST['nome'];
		$this -> cpf = $strCPF;
		$this -> email = $_REQUEST['email'];
		$this -> telefone = str_replace("_","",$_REQUEST['telefone']);
		$this -> celular = str_replace("_","",$_REQUEST['celular']);
		$this -> senha = "";
		$this -> ativo = 0;
		$this -> foto = "avatar.png";
		if ($_FILES['foto']['name'] != "") {
			//incluir imagem se ouver
			$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
			$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
			$this -> foto = $nomefoto;
		}		
		$this -> save();
        
        //altera as permissoes de academias
            $this->apagaPermissoes();
            $this->salvaPermissoes($_REQUEST['academias']);
        
        $email = new Email();
        $email->enviarEmailNovoUsuario($this->nome,$this->email,$this->id);
		$_SESSION['fmj.mensagem'] = 4;
		header("Location:admin_usuario-main");
		exit();

	}

	

	function Alterar() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['email'], $_REQUEST['id'])) {
			$_SESSION['fmj.mensagem'] = 3;
			header("Location:admin_usuario-editar?id=" . $this -> md5_encrypt($_REQUEST['id']));
			exit();
		} else {
			$this -> getById($_REQUEST['id']);
			$p = new Perfil();
			$p -> id = $_REQUEST['perfil'];
			$this -> perfil = $p;
			$this -> nome = $_REQUEST['nome'];
			$this -> telefone = str_replace("_","",$_REQUEST['telefone']);
			$this -> celular = str_replace("_","",$_REQUEST['celular']);
			$this -> cpf = $strCPF;
			$this -> email = $_REQUEST['email'];
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);
			$this -> ativo = $_REQUEST['ativo'];

			
			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> foto != "avatar.png")
					$this -> apagaImagem($this -> foto, "img/users/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
				$this -> foto = $nomefoto;
			}		

			$this -> save();    
            
            //altera as permissoes de academias
            $this->apagaPermissoes();
            $this->salvaPermissoes($_REQUEST['academias']);
                                
			$_SESSION['fmj.mensagem'] = 5;
			header("Location:admin_usuario-main?idPerfil=".$this->md5_encrypt($p -> id));
			exit();
		}
	}

	


	function AlterarMeusDados() {
		$strCPF = $this -> limpaCpf($_REQUEST['cpf']);
		if ($this -> recuperaPorLogin($_REQUEST['email'], $_SESSION['fmj.userId'])) {
			$_SESSION['fmj.mensagem'] = 3;
			header("Location:admin_usuario-dados");
			exit();
		} else {
			$this -> getById($_SESSION['fmj.userId']);
			$this -> nome = $_REQUEST['nome'];
			$this -> cpf = $strCPF;
			$this -> email = $_REQUEST['email'];
			$this -> telefone = $_REQUEST['telefone'];
			$this -> celular = $_REQUEST['celular'];
			if ($_REQUEST['senha'] != "")
				$this -> senha = md5($_REQUEST['senha']);

			//incluir imagem se ouver
			if ($_FILES['foto']['name'] != "") {
				if ($this -> foto != "avatar.png")
					$this -> apagaImagem($this -> foto, "img/users/");
				$nomefoto = $this -> retornaNomeUnico($_FILES['foto']['name'], "img/users/");
				$this -> salvarFoto($_FILES['foto'], $nomefoto, "img/users/");
				$this -> foto = $nomefoto;
			}
			

			$this -> save();
			$_SESSION['fmj.mensagem'] = 5;
			header("Location:admin_home-home");
			exit();
		}
	}

	
    public function apagaPermissoes(){
        $SQL = "delete from fmj_permissao where idUsuario = ".$this->id;
        $this->DAO_ExecutarDelete($SQL);
    }
    
    public function salvaPermissoes($permissoes){
        $arrayP = explode(",", $permissoes);
        foreach ($arrayP as $key => $value) {
            $p = new Permissao();
            $p->usuario = $this;
            $p->academia = new Academia($value);
            $p->save();
        }
    }
    function loginMd5($param1, $param2) {
            
       $login = $this->md5_decrypt($param1);
       $senha = $this->md5_decrypt($param2);
        
        if ($this -> recuperaPorLogin($login)) {
            if ($this -> ativo == 1) {
                if ($this -> senha == $senha) {
                    $_SESSION['fmj.userId'] = $this -> id;
                    $_SESSION['fmj.userNome'] = $this -> nome;
                    $_SESSION['fmj.userPerfil'] = $this -> perfil -> descricao;
                    $_SESSION['fmj.userFoto'] = $this -> foto;
                    $_SESSION['fmj.userPerfilId'] = $this -> perfil -> id;                  
                    //grava a log
                $log = new Log();
                
                $log->gerarLog("Entrou no Sistema através de link de email.");
                    
                    //carrega os itens de menu do perfil
                    $a = new Acesso();
                    $lista = $a -> recuperaMenuAcessos($this -> perfil -> id);
                    $_SESSION['fmj.menu'] = "0";
                    foreach ($lista as $key => $acesso) {
                        $_SESSION['fmj.menu'] .= "," . $acesso -> menu -> id;
                    }
                    return true;
                } else {
                    
                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, senha inválida");
                    
                    $_SESSION['fmj.mensagem'] = 2;
                    return false;
                }
            } else {
                //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, usuário inativo");
                
                $_SESSION['fmj.mensagem'] = 12;
                return false;
            }
        } else {
            //login invalido
            //grava a log
                    $log = new Log();
                    $log->gerarLog("Tentativa de Login, Login inválido");
            
            $_SESSION['fmj.mensagem'] = 1;
            return false;
        }

    }

}
?>