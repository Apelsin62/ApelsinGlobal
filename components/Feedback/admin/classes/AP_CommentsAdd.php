<?php
/**
 * Description of AP_EditCommentsAdd
 *
 * @author olga
 */
class AP_CommentsAdd extends AdminPanel_ComponentPanelUI_Element_Add {
    
    protected function getInputBlocks() { 
        $html = parent::getInputBlocks();
            // ip
            $ip = $this->inputHelper->select('ip', 'ip', $this->getDataIP(), true, $this->originalInsertValue['ip']);
            $html .= $this->inputHelper->createFormRow($ip, true, 'IP');
            // fio
            $fio = $this->inputHelper->paternTextBox('fio', 'fio', 'fio', 100, true, 'Латиница, кирилица, цифры, знак пробела', '[А-Яа-яЁёЙйЦцA-Za-z0-9\s]{2,100}', $this->originalInsertValue['fio']);
            $html .= $this->inputHelper->createFormRow($fio, true, 'Представьтесь');
            // created
            $created = $this->inputHelper->paternTextBox('date', 'date', 'date', 25, true, 'ГГГГ-ММ-ДД чч:мм:сс', '[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}', $this->originalInsertValue['date']);
            $html .= $this->inputHelper->createFormRow($created, true, 'Дата создания');
            // phone
            $phone = $this->inputHelper->paternTextBox('phone', 'phone', 'phone', 100, false, "+7(XXX)XXX-XX-XX", "^((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?$", $this->originalInsertValue['phone']);
            $html .= $this->inputHelper->createFormRow($phone, false, '** Номер телефона');
            // email
            $email = $this->inputHelper->paternTextBox('email', 'email', 'email', 200, false, "user@domen.zone", "^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$", $this->originalInsertValue['email']);
            $html .= $this->inputHelper->createFormRow($email, false, '** E-mail');
            // title
            $title = $this->inputHelper->paternTextBox('title', 'title', 'title', 100, false, 'Латиница, кирилица цифры и знаки - и _ и ()', '[А-Яа-яЁёЙйЦцA-Za-z0-9-_\)\(\s]{2,100}', $this->originalInsertValue['title']);
            $html .= $this->inputHelper->createFormRow($title, false, 'Тема');
            // text
            $text = $this->inputHelper->textarea('text', 'text', 'text', 50000, true,$this->originalInsertValue['text']);
            $html .= $this->inputHelper->createFormRow($text, true, 'Текст');
            // like
            $like = $this->inputHelper->paternTextBox('like', 'like', 'like', 10, false, 'Целое числовое значение', '[0-9)\({1,10}', $this->originalInsertValue['like']);
            $html .= $this->inputHelper->createFormRow($like, false, 'Like');
            // dislike
            $dislike = $this->inputHelper->paternTextBox('dislike', 'dislike', 'dislike', 10, false, 'Целое числовое значение', '[0-9)\({1,10}', $this->originalInsertValue['dislike']);
            $html .= $this->inputHelper->createFormRow($dislike, false, 'Dislike');
            // parentFeedback
            $parentFeedback = $this->inputHelper->paternTextBox('parentFeedback', 'parentFeedback', 'parentFeedback', 20, true, 'Целое числовое значение', '[0-9)\({1,20}', $this->originalInsertValue['parentFeedback']);
            $html .= $this->inputHelper->createFormRow($parentFeedback, true, 'Номер комментируемого отзыва');
            
            $feedbackFormFootNote = '<div class="feedbackFormFootNoteAdmin">Одно из полей \'Номер телефона\' или \'E-mail\' должно быть обязательно заполнено</div>';
            $html .= $this->inputHelper->createFormRow($feedbackFormFootNote, false, '**');
        return $html;
    }
    
    protected function setDefaltInput() { 
        parent::setDefaltInput();
        $yourUser = new UserData();
        $authorization = $yourUser->checkAuthorization();
        if($authorization) {
            $userData = $yourUser->getUserData();
        }
        $this->insertValue['ip'] = parent::getOriginalPostValue('ip');
//        $this->insertValue['fio'] = parent::getOriginalPostValue('fio');
        $this->insertValue['fio'] = $userData['login'];
        $this->insertValue['date'] =  date("Y-m-d h:i:s");
        $this->insertValue['phone'] = parent::getOriginalPostValue('phone');
        $this->insertValue['email'] = parent::getOriginalPostValue('email');
        $this->insertValue['title'] = parent::getOriginalPostValue('title');
        $this->insertValue['text'] = parent::getOriginalPostValue('text');
        $this->insertValue['like'] = parent::getOriginalPostValue('like');
        $this->insertValue['dislike'] = parent::getOriginalPostValue('dislike');
        $this->insertValue['parentFeedback'] = parent::getOriginalPostValue('parentFeedback');
        $this->originalInsertValue = $this->insertValue;
    }

    protected function getAllValue() {
        parent::getAllValue();
        $this->insertValue = array();
        $this->insertValue['ip'] = parent::getPostValue('ip');
        $this->insertValue['fio'] = parent::getPostValue('fio');
        $this->insertValue['date'] = parent::getPostValue('date');
        $this->insertValue['phone'] = parent::getPostValue('phone');
        $this->insertValue['email'] = parent::getPostValue('email');
        $this->insertValue['title'] = parent::getPostValue('title');
        $this->insertValue['text'] = parent::getPostValue('text');
        if(isset($_POST['like']) && $_POST['like']!=null && $_POST['like']!="") {
            $this->insertValue['like'] = parent::getPostValue('like');
        } else {
            $this->insertValue['like'] = '0';
        }
        if(isset($_POST['dislike']) && $_POST['dislike']!=null && $_POST['dislike']!="") {
            $this->insertValue['dislike'] = parent::getPostValue('dislike');
        } else {
            $this->insertValue['dislike'] = '0';
        }
        $this->insertValue['parentFeedback'] = parent::getPostValue('parentFeedback');
    }
    
    protected function checkAllValue() {         
        parent::checkAllValue();
        $error = false;
        if(!$this->checkValue('ip')) {
            $error = true;
            $this->checkAllValueErrors[] = "Выберите IP";
        }
        if(!$this->checkValue('fio',"/[А-Яа-яЁёЙйЦцA-Za-z0-9\s]{2,100}+$/u")) {
            $error = true;
            $this->checkAllValueErrors[] = "Разрешена латиница, кирилица, цифры, знак пробела";
        }
        if(!$this->checkValue('date',"/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/")) {
            $error = true;
            $this->checkAllValueErrors[] = "Заполните поле в формате ГГГГ-ММ-ДД чч:мм:сс";
        }
        if((isset($_POST['phone']) && $_POST['phone']!=null && $_POST['phone']!="") || (isset($_POST['email']) && $_POST['email']!=null && $_POST['email']!="")) {
            if(isset($_POST['phone']) && $_POST['phone']!=null && $_POST['phone']!="" ) {
                if(!$this->checkValue('phone',"/^((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?$/")) {
                    $error = true;
                    $this->checkAllValueErrors[] = "Неверно указан номер телефона. Данные добавляются без пробелов";
                }
            }
            if(isset($_POST['email']) && $_POST['email']!=null && $_POST['email']!="" ) {
                if(!$this->checkValue('email',"/^([A-Za-z0-9_\.-]+)@([A-Za-z0-9_\.-]+)\.([A-Za-z\.]{2,6})$/")) {
                    $error = true;
                    $this->checkAllValueErrors[] = "Указан не корректный E-mail.";
                }
            }
        } else {
            $error = true;
            $this->checkAllValueErrors[] = "Одно из полей 'Номер телефона' или 'E-mail' должно быть заполнено";
        }
        if(isset($_POST['title']) && $_POST['title']!=null && $_POST['title']!="" ) {
            if(!$this->checkValue('title',"/[^А-ЯA-Z]{1}[А-ЯA-Zа-яa-z0-9-_\)\(\s]{1,99}+$/u")) {
                $error = true;
                $this->error[] = "Разрешена латиница, кирилица цифры, тире, нижнее подчеркивание и скобки ";
            }
        }
        if(!$this->checkValue('text')) {
            $error = true;
            $this->checkAllValueErrors[] = "Введите текст";
        }
        if(isset($_POST['like']) && $_POST['like']!=null && $_POST['like']!="" ) {
            if(!$this->checkValue('like',"/^[0-9]{1,10}$/",true)) {
                $error = true;
                $this->checkAllValueErrors[] = "Целое числовое значение";
            }
        }
        if(isset($_POST['dislike']) && $_POST['dislike']!=null && $_POST['dislike']!="" ) {
            if(!$this->checkValue('dislike',"/^[0-9]{1,10}$/",true)) {
                $error = true;
                $this->checkAllValueErrors[] = "Целое числовое значение";
            }
        }
        if(!$this->checkValue('parentFeedback',"/^[0-9]{1,10}$/")) {
            $error = true;
            $this->checkAllValueErrors[] = "Целое числовое значение";
        }
        return !$error;
    }
    
    protected function insertExecute() {
        parent::insertExecute();
        $queryFeedbacks = "INSERT INTO `Feedbacks` SET ";
        $queryFeedbacks .= "`ip` = '".$this->insertValue['ip']."', ";
        $queryFeedbacks .= "`fio` = '".$this->insertValue['fio']."', ";
        $queryFeedbacks .= "`title` = ".InputValueHelper::mayByNull($this->insertValue['title']).", ";
        $queryFeedbacks .= "`text` = '".$this->insertValue['text']."', ";
        $queryFeedbacks .= "`email` = ".InputValueHelper::mayByNull($this->insertValue['email']).", ";
        $queryFeedbacks .= "`phone` = ".InputValueHelper::mayByNull($this->insertValue['phone']).", ";
        $queryFeedbacks .= "`date` = '".date("Y-m-d h:i:s")."', ";
        $queryFeedbacks .= "`rating` = 'noRating', ";
        $queryFeedbacks .= "`show` = '1', ";
        $queryFeedbacks .= "`like` = '".$this->insertValue['like']."', ";
        $queryFeedbacks .= "`dislike` = '".$this->insertValue['dislike']."'; ";
        
        $queryListIP = "INSERT INTO `FeedbacksListIP` SET ";
        $queryListIP .= "`ip` = '".$this->insertValue['ip']."', ";
        $queryListIP .= "`status` = 'default';";
        
        // 8(910)567-58-98
        // sokolovka@apelsin.ru
       
        if ($this->getDataListIP($this->insertValue['ip']) == null) {
            $this->SQL_HELPER->insert($queryListIP);
//            echo var_dump($queryListIP). '<hr>';
       
            $this->SQL_HELPER->insert($queryFeedbacks);
//            echo var_dump($queryFeedbacks). '<hr>';

            $this->insertValue['alias'] = $this->SQL_HELPER->lastInsertID();  

            $queryIsComments = "INSERT INTO `FeedbacksIsComments` SET ";
            $queryIsComments .= "`feedback` = '".$this->insertValue['alias']."', ";
            $queryIsComments .= "`parentFeedback` = '".$this->insertValue['parentFeedback']."'; ";

            $this->SQL_HELPER->insert($queryIsComments);
//            echo var_dump($queryIsComments). '<hr>';
        } else {
            $this->SQL_HELPER->insert($queryFeedbacks);
//            echo var_dump($queryFeedbacks). '<hr>';

            $this->insertValue['alias'] = $this->SQL_HELPER->lastInsertID();  

            $queryIsComments = "INSERT INTO `FeedbacksIsComments` SET ";
            $queryIsComments .= "`feedback` = '".$this->insertValue['alias']."', ";
            $queryIsComments .= "`parentFeedback` = '".$this->insertValue['parentFeedback']."'; ";

            $this->SQL_HELPER->insert($queryIsComments);
//            echo var_dump($queryIsComments). '<hr>';
        } 
    }
    
    private function getDataIP() {
        $rating = array();
        $query = "SELECT  *  FROM `FeedbacksListIP`;";
        $result = $this->SQL_HELPER->select($query);
        foreach ($result as $key => $value) {
            $rating[$key]['text'] = $value['ip']."&nbsp;&nbsp;&nbsp;&nbsp; || &nbsp;&nbsp; СТАТУС - ".$value['status'];
            $rating[$key]['value'] = $value['ip'];
        }
        $ip = $_SERVER['REMOTE_ADDR'];
//        $ip = '555.555.555';
        $rating[$key]['text'] = 'Текущий IP';
//        $rating[$key]['text'] = 'Текущий IP ' .$ip;
        $rating[$key]['value'] = $ip;
        return $rating;
    }
    
    private function getDataListIP($ip) {
        $query = "SELECT `ip` FROM `FeedbacksListIP`  WHERE `ip` = '".$ip."';";
        $checkIPAndStatus = $this->SQL_HELPER->select($query,1);
        return $checkIPAndStatus > 0 ? $checkIPAndStatus['ip'] : null;
    }
}