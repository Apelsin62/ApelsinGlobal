<?php
header("Content-type: text/html; charset=UTF-8");
if ($_POST) {
    $msg = $_POST;
    $feedback = new ContactsUnitFeedback($msg);
    echo $feedback->get();
}

class ContactsUnitFeedback {
    
    private $msg = array();
    private $error;

    public function __construct($msg) {
        $this->msg = array();
        $this->msg = $msg;
    }
    
    private function checkValue() {
        $error = true;
        if((isset($_POST['fio']) && $_POST['fio']!=null && $_POST['fio']!="") &&
            (isset($_POST['shop']) && $_POST['shop']!=null && $_POST['shop']!="") &&
            (isset($_POST['mail']) && $_POST['mail']!=null && $_POST['mail']!="") &&
            (isset($_POST['comments']) && $_POST['comments']!=null && $_POST['comments']!="") &&
            (isset($_POST['rating']) && $_POST['rating']!=null && $_POST['rating']!="" 
                    && $_POST['rating']>0 && $_POST['rating']<6)){
            $mail = $_POST['mail'];
            if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $mail)) {
                $this->error = "Некорректно введен E-mail.";
                $error = false;
            }
        } else {
            $this->error = "Не заполнены обязательные поля";
            $error = false;
        }
        return $error;
    }
    
    private function getMessage() {
        if ($this->checkValue()) {
            $headers = "Content-Type: text/plain; charset=UTF-8\r\n";
            $headers .= "From: ".$this->msg['mail']."\r\n";
            $message = "Магазин: ".$this->msg['shop']."\r\n";
            $message .= "ФИО: ".$this->msg['fio']."\r\n";
            $message .= "Email: ".$this->msg['mail']."\r\n";
            $message .= "Комментарии: ".$this->msg['comments']."\r\n";
            $message .= "Рейтинг: ".$this->msg['rating']."\r\n";
            $message .= "Дата: ".date("d.m.Y - h:i:s")."\r\n";
            $this->error = "Ваш отзыв успешно добавлен. 
                Наши менеджеры рассмотрят его в ближайшее 
                время и при необходимости свяжутся с вами по E-mail";
//            $this->error .= $message;
            echo '<script language="JavaScript">';
            echo "$(document).ready(function(){";
            echo "$('#ajaxContactsUnitFeedback".$this->msg['shop']."').trigger( 'reset' );";

            echo "});";
            echo '</script>';
            
//            if(!mail($this->msg['mail'], 'Отзыв', $message, $headers )){
//                $this->error = 'Ошибка при отправке сообщения<br>';
//            }
        }
    }

    public function get() {
        $this->getMessage();
        return $this->error;
    }
}