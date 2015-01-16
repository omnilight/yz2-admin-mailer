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

    public function actionSend()
    {
        $mutex = new FileMutex();
        if ($mutex->acquire(__CLASS__) === false) {
            $this->stdout("Another instance is running...\n");
            return self::EXIT_CODE_NORMAL;
        }

        $mailsQuery = Mail::find()->where(['status' => Mail::STATUS_WAITING])->orderBy('created_at ASC');

        foreach ($mailsQuery->each() as $mail) {
            /** @var Mail $mail */
            $this->stdout("Sending mail #{$mail->id}\n");
            $mail->send();
        }

        return self::EXIT_CODE_NORMAL;
    }
}