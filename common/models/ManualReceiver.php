<?php

namespace yz\admin\mailer\common\models;
use yii\base\Object;


/**
 * Class ManualReceiver
 */
class ManualReceiver extends Object implements MailReceiverInterface
{
    use MailReceiverTrait;

    public $email;

    /**
     * @return string
     */
    public function getReceiverEmail()
    {
        return $this->email;
    }

    /**
     * Returns an array of mail receiver variables, that are can be used in the mail
     * @return array
     */
    public function getReceiverVariables()
    {
        return [
            '{email}' => $this->email,
        ];
    }
}