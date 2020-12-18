<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {

	const USERNAME = "williamjvcpaiva@gmail.com";
	const PASSWORD = "wingeleven0419";
	const NAME_FROM = "LunaArts";

	private $mail;

	public function __construct($toAdress, $toName, $subject, $tplName, $data = array())
	{
		$config = array(
			"tpl_dir"       =>$_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     =>$_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
		);
	
	    Tpl::configure($config);

	    $tpl = new Tpl;

	    foreach ($data as $key => $value) {
	    	$tpl->assign($key, $value);
	    }

	    $html = $tpl->draw($tplName, true);



		// Crie uma nova instância do PHPMailer
		$this->mail = new \PHPMailer;

		// Diga ao PHPMailer para usar SMTP
		$this->mail -> isSMTP ();

		// Ativar depuração SMTP
		// SMTP :: DEBUG_OFF = desativado (para uso em produção)
		// SMTP :: DEBUG_CLIENT = mensagens do cliente
		// SMTP :: DEBUG_SERVER = mensagens do cliente e do servidor
		$this->mail -> SMTPDebug = 0;

		// Define o nome do host do servidor de email
		$this->mail -> Host = 'smtp.gmail.com' ;
		// usar
		// $ mail-> Host = gethostbyname ('smtp.gmail.com');
		// se sua rede não suportar SMTP sobre IPv6

		// Defina o número da porta SMTP - 587 para TLS autenticado, também conhecido como envio SMTP RFC4409
		$this->mail -> Port = 587 ;

		// Defina o mecanismo de criptografia a usar - STARTTLS ou SMTPS
		$this->mail->SMTPSecure = 'tls' ;

		// Se deve usar autenticação SMTP
		$this->mail -> SMTPAuth = true ;

		// Nome de usuário a ser usado para autenticação SMTP - use o endereço de e-mail completo para o gmail
		$this->mail -> Username = Mailer::USERNAME;

		// Senha a ser usada para autenticação SMTP
		$this->mail -> Password = Mailer::PASSWORD;

		// Define de quem a mensagem deve ser enviada
		$this->mail -> setFrom (Mailer::USERNAME, Mailer::NAME_FROM);

		// Defina um endereço de resposta alternativo
		//$ mail -> addReplyTo ( 'replyto@example.com' , 'Primeiro Último' );

		// Defina para quem a mensagem deve ser enviada
		$this->mail -> addAddress ( $toAdress , $toName);

		// Define a linha de assunto
		$this->mail->Subject = $subject;

		// Leia um corpo da mensagem HTML de um arquivo externo, converta imagens referenciadas em incorporadas,
		//convert HTML into a basic plain-text alternative body
		$this->mail->msgHTML($html);

		//Replace the plain text body with one created manually
		$this->mail->AltBody = 'This is a plain-text message body';

		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		

		//Section 2: IMAP
		//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
		//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
		//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
		//be useful if you are trying to get this working on a non-Gmail IMAP server.
	}

	public function send()
	{

		return $this->mail->send();
	}
}

?>