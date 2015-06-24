<?php
namespace yz\admin\mailer\common\mailing;
use yz\admin\mailer\common\models\Mail;


/**
 * Interface MailRecipientInterface
 */
interface MailRecipientInterface
{
    /**
     * @return string
     */
    public function getRecipientEmail();
    /**
     * Returns an array of mail receiver variables, that are can be used in the mail
     * @return array
     */
    public function getRecipientVariables();
    /**
     * Sends letter to the mail receiver
     * @param Mail $mail
     * @return true
     */
    public function sendToRecipient($mail);
}