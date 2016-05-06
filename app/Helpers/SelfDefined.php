<?php
namespace Helpers;

class SelfDefined
{

    public static function get_auth_plained()
    {
		$char='';
		for ($i = 1; $i <= 4; $i++) {
			$char.=chr(rand(65, 90));
			$char.=chr(rand(97, 122));
		}
		
        return $char;
    }
	
	public static function send_email_new_one_invite($send_to, $send_auth_token){
		$mail = new PhpMailer\Mail();
		$mail->Charset='UTF-8';
		$mail->setFrom('brs_maillist@mail.bistu.edu.cn');
		$mail->addAddress($send_to);
		$mail->Subject = '=?utf-8?B?' . base64_encode('加入UIM') . '?=';;
		$mail->body("
		歡迎您加入UIM。<br />
		我們為您申請了壹個賬號，您可以隨時點擊下面的鏈接激活賬號。成功激活後，您便可以使用賬戶的所有功能。<br />
		<ul><li>如果您並不了解如何使用，請您與我們聯絡。</li><li>如果您並不清楚這是什麽，請您忽略。</li></ul>"."
		<a href=\"".DIR."login/activate/".$send_auth_token."\">激活</a><br />
		<br />
		如有打擾，望您海涵。順祝<br />
		臺安<br />
		<br />
		信息科大校園之聲 | UIM團隊<br />".
		date("Y")."年".date("m")."月".date("d")."日");
		$mail->send();
		
	}

    
}
