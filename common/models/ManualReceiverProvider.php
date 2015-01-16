<?php

namespace yz\admin\mailer\common\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;


/**
 * Class ManualReceiverProvider
 */
class ManualReceiverProvider extends Model implements ReceiversProviderInterface
{
    /**
     * @var string
     */
    public $to;

    /**
     * @return string
     */
    public static function backendFormView()
    {
        return '@yz/admin/mailer/backend/views/receiversProviders/manual.php';
    }

    /**
     * @return string
     */
    public static function providerTitle()
    {
        return \Yii::t('admin/mailer', 'Manual receiver');
    }

    public function rules()
    {
        return [
            [['to'], 'required'],
        ];
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function getProviderData()
    {
        return [
            'to' => $this->to,
        ];
    }

    public function attributeLabels()
    {
        return [
            'to' => \Yii::t('admin/mailer', 'Email получателей')
        ];
    }


    /**
     * @return \Iterator|MailReceiverInterface[]
     */
    public function getReceivers()
    {
        $emails = preg_split('/\s*;\s*/', $this->to, -1, PREG_SPLIT_NO_EMPTY);
        $receivers = [];
        foreach ($emails as $email) {
            $receivers[] = new ManualReceiver([
                'email' => $this->to
            ]);
        }
        return new \ArrayIterator($receivers);
    }

    /**
     * Returns true if it is possible to send mails immediately. Otherwise they will be sent
     * via cron job
     * @return bool
     */
    public function getCanSendImmediately()
    {
        return true;
    }
}