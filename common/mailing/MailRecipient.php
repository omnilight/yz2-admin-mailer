<?php
namespace yz\admin\mailer\common\mailing;
use yii\di\Instance;
use yii\mail\MailerInterface;
use yz\admin\mailer\common\models\Mail;


/**
 * Trait MailRecipient gives standard functions for mail receivers
 */
trait MailRecipient
{
    public function getRecipientMailer()
    {
        return \Yii::$app->mailer;
    }

    /**
     * @param Mail $mail
     */
    public function sendToRecipient($mail)
    {
        /** @var MailRecipientInterface|MailRecipient $this  */
        $this->getRecipientMailer()
            ->compose('@yz/admin/mailer/common/mails/adminMailer.php', [
                'mail' => $mail,
                'subject' => strtr($mail->subject, $this->getRecipientVariables()),
                'body' => strtr($mail->body_html, $this->getRecipientVariables()),
            ])
            ->setTo($this->getRecipientEmail())
            ->setFrom([$mail->from => $mail->from_name])
            ->send();
    }
}