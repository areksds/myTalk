<?php 

include __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../scripts/PHPMailer/Exception.php';
require __DIR__ . '/../scripts/PHPMailer/PHPMailer.php';
require __DIR__ . '/../scripts/PHPMailer/SMTP.php';
require __DIR__ . '/mail_messages.php';

$host = $config['email']['host'];
$password = $config['email']['password'];
$username = $config['email']['username'];
$type = $config['email']['type'];
$port = $config['email']['port'];
$from = $config['email']['address'];
$id = $version['id'];

function sendMail($email, $name, $subject, $message, $link) {
	
global $host;
global $password;
global $username;
global $type;
global $port;
global $from;
global $id;
	
	$mail = new PHPMailer(true);
	
	try {
		//Server settings
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $username;                 // SMTP username
		$mail->Password = $password;                           // SMTP password
		if ($type == 'tls' || $type == 'ssl') {
			$mail->SMTPSecure = $type;                            // Enable TLS encryption, `ssl` also accepted
		}
		$mail->Port = $port;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom($from, 'myTalk | ' . $id);
		$mail->addAddress($email, $name);     // Add a recipient

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = mailSubject($subject, $name);
		$mail->Body    = mailMessage($message, $name, $link);
		$mail->AltBody = mailText($message, $name, $link);

		$mail->send();
		return 1;
	} catch (Exception $e) {
		return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
	}
}

?>