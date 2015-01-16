<?php
namespace yz\admin\mailer\common\models;
use yii\mail\MailerInterface;
use yii\di\Instance;


/**
 * Trait MailReceiverTrait gives standard functions for mail receivers
 */
trait MailReceiverTrait
{
    /**
     * @var string|MailerInterface|array
     */
    public $mailer = 'mailer';
    /**
     * @param Mail $mail
     */
    public function sendToReceiver($mail)
    {
        /** @var MailReceiverInterface|self $this */
        $this->mailer = Instance::ensure($this->mailer, 'yii\mail\MailerInterface');
        $this->mailer
            ->compose('@yz/admin/mailer/common/mails/adminMailer.php', [
                'mail' => $mail,
                'subject' => strtr($mail->subject, $this->getReceiverVariables()),
                'body' => strtr($mail->body_html, $this->getReceiverVariables()),
            ])
            ->setTo($this->getReceiverEmail())
            ->setFrom([$mail->from => $mail->from_name])
            ->send();
    }
}