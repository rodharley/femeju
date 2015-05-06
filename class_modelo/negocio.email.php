<?php
class Email extends Persistencia{
	const ASSINATURA = "Atenciosamente,<br/>Suporte da Femeju<br/><a href='#url#'><img src='#url#/img/logo.png' width='120'/></a>";			
	var $assunto;
	var $conteudo;
	var $tipo;
	
	
	
function enviarEmailRedefinirSenha($nome, $email,$idUsuario){
		$mensagem = "Sr(a). $nome, sua senha foi redefinida. Clique <a href='".URL. "/admin_usuario-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para gerar uma nova senha.";
		$tplEmail = new Template("templates/padrao/email.html");
		$tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);
		$tplEmail -> MENSAGEM = $mensagem;
		return $this -> mail_html($email, $this -> remetente, "FEMEJU - Redefinição de Senha", $tplEmail -> showString());
}

function enviarEmailNovoUsuario($nome, $email,$idUsuario){
        $mensagem = "Sr(a). $nome, você foi cadastrado como usuário do sistema FEMEJU. Clique <a href='".URL . "/admin_usuario-ativar?id=" . $this -> md5_encrypt($idUsuario)."'>Aqui</a> para ativar seu usuário.";
        $tplEmail = new Template("templates/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);
        $tplEmail -> MENSAGEM = $mensagem;
        return $this -> mail_html($email, $this -> remetente, "FEMEJU - Cadastramento no Sistema", $tplEmail -> showString());
}
function enviarEmailNovaSenha($nome, $email,$senha){
        $mensagem = "Sr(a). $nome, sua nova senha para acesso é:<strong>$senha</strong>";
        $tplEmail = new Template("templates/padrao/email.html");
        $tplEmail -> ASSINATURA = str_replace("#url#",URL,Email::ASSINATURA);        
        $tplEmail -> MENSAGEM = $mensagem;        
        return $this -> mail_html($email, $this -> remetente, "FEMEJU - Nova Senha", $tplEmail -> showString());
}


}
?>