<?php
/**
 * 作用：邮件类
 * 官网：Http://www.sdcms.cn
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_mail
{
    public $mailer;
    public $delimiter;
    public $charset='utf-8';
    public $sender;
    public $from;
    public $sign;
    public $smtp_host;
    public $smtp_port;
    public $smtp_auth;
    public $smtp_username;
    public $smtp_password;

    public $error = '';

    public function __construct()
    {
        $this->mailer           = C('mail_type');
        $this->delimiter        = C('mail_split');
        $this->sender           = C('mail_name');
        $this->from             = C('mail_user');
        $this->sign             = C('mail_sign');
        $this->smtp_host        = C('mail_smtp');
        $this->smtp_port        = C('mail_port');
        $this->smtp_auth        = C('mail_auth');
        $this->smtp_username    = C('mail_user');
        $this->smtp_password    = C('mail_pass');
    }

    public function send($sendto, $subject, $message, $from = null)
    {
        if($this->mailer==0)
        {
            return false;
        }
        $this->delimiter = $this->delimiter == 1 ? "\r\n" : ($this->delimiter == 2 ? "\r" : "\n");
        $this->sender = empty($this->sender) ? 'sdcms' : $this->sender;

        if (is_null($from))
        {
            $from = '=?' . $this->charset . '?B?' . base64_encode($this->sender) . "?= <$this->from>";
        }
        else
        {
            $from = preg_match('/^(.+?) \<(.+?)\>$/', $from, $m) ? '=?' . $this->charset . '?B?' . base64_encode($m[1]) . "?= <$m[2]>" : $from;
        }

        $sendtos = array();
        if (strpos($sendto, ','))
        {
            foreach (explode(',', $sendto) as $to)
            {
                $sendtos[] = preg_match('/^(.+?) \<(.+?)\>$/', $to, $m) ? '=?' . $this->charset . '?B?' . base64_encode($m[1]) . "?= <$m[2]>" : $to;
            }
            $sendto = implode(',', $sendtos);
        }

        $subject = '=?' . $this->charset . '?B?' . base64_encode(str_replace("\r", '', str_replace("\n", '', $subject))) . '?=';

        $message .= empty($this->sign) ? '' : '<div style="margin-top:20px;padding:10px 0;border-top:dotted 1px #909090;font:normal 14px/1.2 "Microsoft YaHei",Arial,Narrow;color:#000;"><sign>' . $this->sign . '</sign></div>';
        $message = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message)))))));

        $headers = "From: $from{$this->delimiter}X-Priority: 3{$this->delimiter}X-Mailer: sdcms{$this->delimiter}MIME-Version: 1.0{$this->delimiter}Content-type: text/html; charset=$this->charset{$this->delimiter}Content-Transfer-Encoding: base64{$this->delimiter}";

        if ($this->mailer == 1)
        {
            if (mail($sendto, $subject, $message, $headers))
            {
                return true;
            }
            return $this->error('系统不支持使用当前的发送方式');
        }
        elseif ($this->mailer == 2)
        {
            return $this->smtp($sendto, $subject, $message, $headers, $from);
        }
        else
        {
            if ($this->mailto($sendto, $subject, $message, $headers, $from))
            {
                return true;
            }

            return $this->error('系统不支持使用当前的发送方式');
        }
    }

    function mailto($sendto, $subject, $message, $headers, $from)
    {
        ini_set('SMTP', $this->smtp_host);
        ini_set('smtp_port', $this->smtp_port);
        ini_set('sendmail_from', $from);
        return mail($sendto, $subject, $message, $headers);
    }

    function smtp($to, $subject, $message, $headers, $from)
    {
        if (! $fp = fsockopen($this->smtp_host, $this->smtp_port, $code, $error, 10))
        {
            return $this->error('无法连接smtp服务器，SMTP服务器地址或者端口错误');
        }

        stream_set_blocking($fp, true);
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != '220')
        {
            return $this->error($lastmessage, substr($lastmessage, 0, 3));
        }

        fputs($fp, ($this->smtp_auth ? 'EHLO' : 'HELO') . " sdcms\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250)
        {
            return $this->error($lastmessage, substr($lastmessage, 0, 3));
        }

        while (1)
        {
            if (substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) break;
            $lastmessage = fgets($fp, 512);
        }

        if ($this->smtp_auth)
        {
            fputs($fp, "AUTH LOGIN\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334)
            {
                return $this->error($lastmessage, substr($lastmessage, 0, 3));
            }

            fputs($fp, base64_encode($this->smtp_username) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 334)
            {
                return $this->error($lastmessage, substr($lastmessage, 0, 3));
            }

            fputs($fp, base64_encode($this->smtp_password) . "\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 235)
            {
                return $this->error($lastmessage, substr($lastmessage, 0, 3));
            }
        }

        fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $from) . ">\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250)
        {
            fputs($fp, "MAIL FROM: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $from) . ">\r\n");
            $lastmessage = fgets($fp, 512);
            if (substr($lastmessage, 0, 3) != 250)
            {
                return $this->error($lastmessage, substr($lastmessage, 0, 3));
            }
        }

        $email_tos = array();
        foreach (explode(',', $to) as $touser)
        {
            $touser = trim($touser);
            if ($touser)
            {
                fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
                $lastmessage = fgets($fp, 512);
                if (substr($lastmessage, 0, 3) != 250)
                {
                    fputs($fp, "RCPT TO: <" . preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser) . ">\r\n");
                    $lastmessage = fgets($fp, 512);
                    return $this->error($lastmessage, substr($lastmessage, 0, 3));
                }
            }
        }

        fputs($fp, "DATA\r\n");
        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 354)
        {
            return $this->error($lastmessage, substr($lastmessage, 0, 3));
        }

        $headers .= 'Message-ID: <' . gmdate('YmdHs') . '.' . substr(md5($message . microtime()), 0, 6) . rand(100000, 999999) . '@' . $_SERVER['HTTP_HOST'] . ">{$this->delimiter}";

        fputs($fp, "Date: " . gmdate('r') . "\r\n");
        fputs($fp, "To: " . $to . "\r\n");
        fputs($fp, "Subject: " . $subject . "\r\n");
        fputs($fp, $headers . "\r\n");
        fputs($fp, "\r\n\r\n");
        fputs($fp, $message . "\r\n.\r\n");

        $lastmessage = fgets($fp, 512);
        if (substr($lastmessage, 0, 3) != 250)
        {
            return $this->error($lastmessage, substr($lastmessage, 0, 3));
        }        
        fputs($fp, "QUIT\r\n");
        return true;
    }

	public function error($error = '')
	{
		if (empty($error))
		{

			return $this->error ? $this->error : false;
		}
		$this->error = $error;
		return false;
	}
}