<?php

define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'judobrasilia');
define('CARREGANDO', '<p align="center"><img src="img/ajax_loading.gif" height="32" /></p>');
define('URI',$_SERVER['DOCUMENT_ROOT']."/judobrasilia");
define('URL','http://'.$_SERVER['HTTP_HOST']."/judobrasilia");
define('DESENVOLVIMENTO',true);
define('REMETENTE','sistema@judobrasilia.com.br');
define('CONTATO','contato@judobrasilia.com.br');
//variaveis do paypal
DEFINE('PAYPAL_USER','rodrigo.cruz76-facilitator_api1.gmail.com');
DEFINE('PAYPAL_PSWD','5SJ3R6MXNMBPB24V');
DEFINE('PAYPAL_SIGNATURE','Ak.dxCX2H81Ae5esl62Csvm2VaFTABlqTydSI9w7fbo56zWE0IN7iA.m');
DEFINE('PAYPAL_SANDBOX',true);
DEFINE('PAYPAL_RETURNURL','judobrasilia/admin_pagamento-paypalReturn?return=1');
DEFINE('PAYPAL_CANCELURL','judobrasilia/admin_pagamento-paypalCancel');  
DEFINE('PAYPAL_TICKETURL','judobrasilia/admin_pagamento-paypalTicket'); 
//variaveis do gerencia net 
DEFINE('GN_CLIENTID','Client_Id_b5708bac7156a148357f6b15b8bbeaae906b7798'); 
DEFINE('GN_CLIENTSECRET','Client_Secret_213c9c8767fed030ad352a6a934fab94e8e2c2a2'); 
DEFINE('GN_NOTIFICATIONURL','judobrasilia/admin_pagamento-gnNotification'); 
DEFINE('GN_SANDBOX',true); 
class Conexao
{
    private static $instance;
    public $connection;

    private function __construct()
    {
        $this->connection = new mysqli(SERVER,USERNAME,PASSWORD,DATABASE);
        //$this->connection->autocommit(false);
        //$this->connection->begin_transaction();
    }

    public static function init()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Conexao();
        }

        return self::$instance;
    }


    public function __call($name, $args)
    {
        if(method_exists($this->connection, $name))
        {
             return call_user_func_array(array($this->connection, $name), $args);
        } else {
             trigger_error('Unknown Method ' . $name . '()', E_USER_WARNING);
             return false;
        }
    }
}
?>