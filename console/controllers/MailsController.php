<?php

namespace yz\admin\mailer\console\controllers;
use console\base\Controller;
use Crontab\Job;
use yii\db\ActiveQuery;
use yii\mutex\FileMutex;
use yz\admin\mailer\common\models\Mail;


/**
 * Class MailsController
 */
class MailsController extends Controller
{
    /**
     * @var string
     */
    public $defaultAction = 'send';

    public function actionSend($status = Mail::STATUS_WAITING)
    {
        $mutex = new FileMutex();
        if ($mutex->acquire(__CLASS__) === false) {
            $this->stdout("Another instance is running...\n");
            return self::EXIT_CODE_NORMAL;
        }

        $mailsQuery = Mail::find()->where(['status' => $status])->orderBy('created_at ASC');

        foreach ($mailsQuery->each() as $mail) {
            /** @var Mail $mail */
            $this->stdout("Sending mail #{$mail->id}\n");
            $counter = 0;
            $mail->on(Mail::EVENT_SINGLE_MAIL_SENT, function() use (&$counter) {
                $counter++;
                $this->stdout("  sent ".$counter."\r");
            });
            $mail->send();
            $this->stdout("\n");
        }

        $mutex->release(__CLASS__);

        return self::EXIT_CODE_NORMAL;
    }

    public function actionList()
    {
        $mailsQuery = Mail::find()->orderBy('created_at ASC');

        foreach ($mailsQuery->each() as $mail) {
            /** @var Mail $mail */
            $this->stdout("#{$mail->id} - {$mail->status}\n");
        }
    }
}