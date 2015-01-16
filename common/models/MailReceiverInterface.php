<?php
namespace yz\admin\mailer\common\models;


/**
 * Interface MailReceiverInterface
 */
interface MailReceiverInterface
{
    /**
     * @return string
     */
    public function getReceiverEmail();
    /**
     * Returns an array of mail receiver variables, that are can be used in the mail
     * @return array
     */
    public function getReceiverVariables();
    /**
     * Sends letter to the mail receiver
     * @param Mail $mail
     * @return true
     */
    public function sendToReceiver($mail);
}