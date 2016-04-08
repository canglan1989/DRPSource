<?php
date_default_timezone_set("PRC");
include 'class.phpmailer.php'; 
class sendemail
{
	public $mailInfo = array(
					'charset' => 'UTF-8',
					'host' => 'smtp.adpanshi.com',
					'smptauth' => true, // turn on SMTP authentication
					'username' => 'link@adpanshi.com', // SMTP username
					'password' => 'lk123456', // SMTP password
					'from' => 'link@adpanshi.com',
			);
	
	public $data = array(
					'formname' => '周大帅2',
					'subject' => "周大帅3",
					'body' => '<img src="http://img.baidu.com/img/iknow/avarta/66/r6s1g4.gif" alt="" onError="this.src=image/nopic.gif" />',
					'altbody' => "周大帅",
					'email' => 'soso24w@hotmail.com',
					'name' => '周大帅哥',
			);
	
	public function email($flag=false)
	{
			$mail = new PHPMailer(true);
			//$mail->SMTPSecure = "ssl"; 
			$mail->CharSet = $this->mailInfo['charset'];  
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->Host = $this->mailInfo['host']; // specify main and backup server
			$mail->SMTPAuth = $this->mailInfo['smptauth'];     // turn on SMTP authentication
			$mail->Username = $this->mailInfo['username'];  // SMTP username
			$mail->Password = $this->mailInfo['password']; // SMTP password
			$mail->From = $this->mailInfo['from'];
			$mail->FromName = isset($this->data['fromname']) ? $this->data['fromname'] : '';
			$mail->AddAddress($this->data['email'],$this->data['name']);
			$mail->WordWrap = isset($this->data['wordwrap']) ? $this->data['wordwrap'] : 50;   // set word wrap to 50 characters
			$mail->IsHTML(isset($this->data['ishtml']) ? isset($this->data['ishtml']) : true);  // set email format to HTML
			
			$mail->Subject = isset($this->data['subject']) ? $this->data['subject'] : '';
			$mail->Body    = isset($this->data['body']) ? $this->data['body'] : '';
			$mail->AltBody = isset($this->data['altbody']) ? $this->data['altbody'] : '';
		//

		if($flag == false) $mail->Send();
		if($flag == true)
		   return !$mail->Send() ? "Mailer Error: " . $mail->ErrorInfo : 1;
	}
}

$email = new sendemail();
$email->email();

?>