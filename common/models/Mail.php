<?php

namespace yz\admin\mailer\common\models;

use Yii;
use yii\helpers\Json;
use yz\interfaces\ModelInfoInterface;

/**
 * This is the model class for table "yz_admin_mails".
 *
 * @property integer $id
 * @property string $status
 * @property string $receivers_provider
 * @property string $receivers_provider_data
 * @property string $from
 * @property string $from_name
 * @property string $subject
 * @property string $body_html
 * @property string $boxy_text
 * @property string $created_at
 */
class Mail extends \yz\db\ActiveRecord implements ModelInfoInterface
{
    const STATUS_NEW = 'new';
    const STATUS_WAITING = 'waiting';
    const STATUS_SENDING = 'sending';
    const STATUS_SENT = 'sent';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_mails}}';
    }

	/**
     * Returns model title, ex.: 'Person', 'Book'
     * @return string
     */
    public static function modelTitle()
    {
        return Yii::t('admin/mailer', 'Mail');
    }

    /**
     * Returns plural form of the model title, ex.: 'Persons', 'Books'
     * @return string
     */
    public static function modelTitlePlural()
    {
        return Yii::t('admin/mailer', 'Mails');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body_html', 'boxy_text'], 'string'],
            [['receivers_provider'], 'string'],
            [['from', 'from_name', 'subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin/mailer', 'ID'),
            'status' => Yii::t('admin/mailer', 'Status'),
            'receiver' => Yii::t('admin/mailer', 'Receiver'),
            'receiver_data' => Yii::t('admin/mailer', 'Receiver Data'),
            'from' => Yii::t('admin/mailer', 'From'),
            'from_name' => Yii::t('admin/mailer', 'From Name'),
            'subject' => Yii::t('admin/mailer', 'Subject'),
            'body_html' => Yii::t('admin/mailer', 'Body Html'),
            'boxy_text' => Yii::t('admin/mailer', 'Boxy Text'),
            'created_at' => Yii::t('admin/mailer', 'Created At'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatusValues()
    {
        return [
            self::STATUS_NEW => Yii::t('admin/mailer', 'New'),
            self::STATUS_WAITING => Yii::t('admin/mailer', 'Waiting for sending'),
            self::STATUS_SENDING => Yii::t('admin/mailer', 'Sending'),
            self::STATUS_SENT => Yii::t('admin/mailer', 'Sent'),
        ];
    }

    /**
     * @var MailReceiverProviderInterface
     */
    protected $_receiversProvider;

    /**
     * @return MailReceiverProviderInterface
     */
    public function getReceiversProvider()
    {
        if ($this->_receiversProvider === null) {
            $this->_receiversProvider = Yii::createObject($this->receivers_provider, Json::decode($this->receivers_provider_data));
        }

        return $this->_receiversProvider;
    }

    public function beforeSave($insert)
    {
        $this->receivers_provider_data = Json::encode($this->_receiversProvider->getReceiversProviderData());

        return parent::beforeSave($insert);
    }


}
