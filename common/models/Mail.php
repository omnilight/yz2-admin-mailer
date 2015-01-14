<?php

namespace yz\admin\mailer\common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yz\admin\mailer\common\Module;
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
 *
 * @property ReceiversProviderInterface $receiversProvider
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

    public function init()
    {
        parent::init();
        if ($this->receivers_provider === null) {
            $this->receivers_provider = ManualReceiverProvider::className();
        }
        if ($this->receivers_provider_data === null) {
            $this->receivers_provider_data = '[]';
        }
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivers_provider'], 'required'],
            [['body_html'], 'required'],
            [['from'], 'required'],
            [['from_name'], 'required'],
            [['subject'], 'required'],

            [['body_html', 'boxy_text'], 'string'],
            [['receivers_provider'], 'in', 'range' => array_keys(self::getReceiversProviderValues())],
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
     * @var array
     */
    protected $_receiversProvider;

    /**
     * @return ReceiversProviderInterface
     */
    public function getReceiversProvider()
    {
        $hash = md5($this->receivers_provider);
        if ($this->_receiversProvider === null) {
            $this->_receiversProvider = [Yii::createObject(array_merge([
                'class' => $this->receivers_provider,
            ], Json::decode($this->receivers_provider_data))), $hash];
        } elseif ($this->_receiversProvider[1] !== $hash) {
            $this->receivers_provider_data = [];
            $this->_receiversProvider = [Yii::createObject(array_merge([
                'class' => $this->receivers_provider,
            ], Json::decode($this->receivers_provider_data))), $hash];
        }

        return $this->_receiversProvider[0];
    }

    public function beforeSave($insert)
    {
        $this->receivers_provider_data = Json::encode($this->getReceiversProvider()->getProviderData());

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public static function getReceiversProviderValues()
    {
        $values = [];
        foreach (Yii::$app->getModule('adminMailer')->receiversProviders as $providerClass) {
            $values[$providerClass] = call_user_func([$providerClass, 'providerTitle']);
        }
        return $values;
    }
}
