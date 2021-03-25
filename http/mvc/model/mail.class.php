<?php

require_once('bdd.class.php');

class mail extends bdd
{
	public static	$verbose = false;
	private			$_me = 'florian.marie.doucet@gmail.com';

	public function doc()
	{
		return file_get_content("mail.doc.txt");
	}

	public function __construct()
	{
		if (self::$verbose == true)
			echo "mail class constructed" . PHP_EOL;
		return ;
	}

	public function __destruct()
	{
		if (self::$verbose == true)
			echo "mail class destroyed" . PHP_EOL;
		return ;
	}

	private function _constructmail($content)
	{
		$message = '<html>';
		$message .=		'<head>';
		$message .=			'<style>';
		$message .=				'body';
		$message .=				'{';
		$message .=					'margin: 0;';
		$message .=					'font-family: Arial, Helvetica, sans-serif;';
		$message .=					'text-align: center;';
		$message .=				'}';
		$message .=				'#header';
		$message .=				'{';
		$message .=					'text-align: center;';
		$message .=					'box-shadow: 0px 2px 2px grey;';
		$message .=					'background: radial-gradient(circle at 30% 107%, ';
		$message .=					'#fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, ';
		$message .=					'#285AEB 90%);';
		$message .=				'}';
		$message .=				'#content';
		$message .=				'{';
		$message .=					'width: 100%;';
		$message .=					'background-color: #f3f3f3;';
		$message .=					'text-align: center;';
		$message .=				'}';
		$message .=				'#footer';
		$message .=				'{';
		$message .=					'background-color: lightgrey;';
		$message .=					'text-align: center;';
		$message .=				'}';
		$message .=				'h1';
		$message .=				'{';
		$message .=					'font-family: sans-serif;';
		$message .=					'color: #fff;';
		$message .=					'padding: 0;';
		$message .=					'margin: 0;';
		$message .=				'}';
		$message .=				'p';
		$message .=				'{';
		$message .=					'text-align: center;';
		$message .=					'padding: 0;';
		$message .=					'margin: 0;';
		$message .=				'}';
		$message .=				'button';
		$message .=				'{';
		$message .=					'background-color: #4CAF50;';
		$message .=					'color: white;';
		$message .=					'padding: 14px 20px;';
		$message .=					'margin: 8px 0;';
		$message .=					'border: none;';
		$message .=					'cursor: pointer;';
		$message .=				'}';
		$message .=			'</style>';
		$message .=		'</head>';
		$message .=		'<body>';
		$message .=			'<div id=header>';
		$message .=				'<h1>Camagru</h1>';
		$message .=			'</div>';
		$message .=			'<div id=content>';
		$message .=				$content;
		$message .=			'</div>';
		$message .=			'<div id=footer>';
		$message .=				'© Camagru-fldoucet 2019';
		$message .=			'</div>';
		$message .=		'</body>';
		$message .=	'</html>';
		return ($message);
	}

	public function sendnotif($email)
	{
		$to  = $email;
		$subject = 'You have a new notification';

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'To: ' . $email;
		$content = '<p>Dear customer, you have a new <b>notification</b> !';
		$content .=	' click on the link below to see what\'s up !</p>';
		$content .= "<form action='https://" . $_SERVER['SERVER_NAME']
			. "/index.php' method=get target='_blank'><button name=page value=notification>Click Here</button></form>";
		$content .=	'<p>Yours sincerely, the Camagru team.</p>';
		$message = $this->_constructmail($content);
		mail($to, $subject, $message, implode("\r\n", $headers), '-F Camagru -f support@camagru.com ');
	}

	public function activateaccount($email, $token, $username)
	{
		$to  = $email;
		$subject = 'Activate your account';

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'To: ' . $email;
		$content = '<p>Dear customer, click on the link below in order</p>';
		$content .= '<p>to gain acces to our website content. See you on Camagru soon !</p>';
		$content .= "<form action='https://" . $_SERVER['SERVER_NAME']
			. "/index.php?page=validation&login=" . $username
			. "' method=post target='_blank'><button name=token value=" . $token . ">Click Here</button></form>";
		$content .=	'<p>Yours sincerely, the Camagru team.</p>';
		$message = $this->_constructmail($content);
		mail($to, $subject, $message, implode("\r\n", $headers), '-F Camagru -f support@camagru.com ');
	}

	public function sendsupport($email, $subject, $problem)
	{
		$to  = $email;
		$subject = 'Your contact from support : ' . $subject;

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'To: ' . $email;
		$content = '<p>Dear customer, thank you for contacting us, our support</p>';
		$content .=	'<p> will soon send you a reponse about your problem.</p>';
		$content .=	'<p>Yours sincerely, the support team.</p>';
		$message = $this->_constructmail($content);
		mail($to, $subject, $message, implode("\r\n", $headers), '-F Camagru -f support@camagru.com ');
		$to  = $this->_me;
		$subject = 'TU code mal regarde : ' . $subject;

		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'To: ' . $email;
		$content = '<p>' . $problem . '</p>';
		$message = $this->_constructmail($content);
		mail($to, $subject, $message, implode("\r\n", $headers), '-F Camagru -f support@camagru.com ');
	}

	public function sendreset($email)
	{
		$bdd = new bdd;
		$db = $bdd->_dbConnect();
		if ($db)
		{
			$sql = "SELECT username FROM Users WHERE `email` = '" . $email . "'";
			$res = $db->prepare($sql);
			$res->execute();
			$ret = $res->setFetchMode(PDO::FETCH_ASSOC);
			$ret = $res->fetchAll();
			if ($ret[0]['username'])
			{
				$token = md5(microtime(true) * rand(0, 100));
				$sql = "UPDATE Users SET token = '" . $token . "' WHERE username = '" . $ret[0]['username'] . "'";
				$db->exec($sql);
				$to  = $email;
				$subject = 'Reset your credentials';

				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=iso-8859-1';
				$headers[] = 'To: ' . $email;
				$content = '<p>Dear customer, click on the link below in order</p>';
				$content .= '<p>to change your personnal informations. See you on Camagru soon !</p>';
				$content .= "<form action='https://" . $_SERVER['SERVER_NAME']
					. "/index.php?page=account&login=" . $ret[0]['username']
					. "' method=post target='_blank'><button name=token value=" . $token . ">Click Here</button></form>";
				$content .=	'<p>Yours sincerely, the Camagru team.</p>';
				$message = $this->_constructmail($content);
				mail($to, $subject, $message, implode("\r\n", $headers), '-F Camagru -f support@camagru.com ');
			}
			echo "email sent !";
		}
	}
}
