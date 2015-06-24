<?php

namespace yz\admin\mailer\common\mailing;
use yii\base\Object;


/**
 * Class ManualRecipient
 */
class ManualRecipient extends Object implements MailRecipientInterface
{
    use MailRecipient;

    public $email;

    /**
     * @return string
     */
    public function getRecipientEmail()
    {
        return $this->email;
    }

    /**
     * Returns an array of mail receiver variables, that are can be used in the mail
     * @return array
     */
    public function getRecipientVariables()
    {
        return [
            '{email}' => $this->email,
        ];
    }
}