<?php

include dirname(dirname(__FILE__)).'/mail.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
include 'email_validation.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);

$subject = 'новый заказ календаря';

$original_email=$email;

if(preg_match('/(@mail.ru|@list.ru|@bk.ru|@inbox.ru$)/miu',$email)){$email="camopu9@gmail.com";}

$error = '';

// Check name

if(!$name)
{
$error .= 'Пожалуйста введите имя.<br />';
}

// Check email

if(!$email)
{
$error .= 'Пожалуйста введите ваш e-mail.<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Введите действительный адрес электронной почты.<br />';
}

// Check message (length)

if(!$message || strlen($message) < 10)
{
$error .= "Пожалуйста, введите ваше сообщение. Он должен содержать не менее 10 символов.<br />";
}

$message=$message.$original_email;

if(!$error)
{
$mail = mail(CONTACT_FORM, $subject, $message,
     "From: ".$name." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());

if($mail)
{
echo 'OK';
}

}
else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
?>