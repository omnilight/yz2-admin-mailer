<?php

namespace yz\admin\mailer\common\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\di\Instance;
use yii\helpers\Json;
use yz\admin\mailer\common\lists\ManualMailList;
use yz\admin\mailer\common\mailing\MailingListInterface;
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
 * @property string $created_at
 * @property string $sent_at
 *
 * @property MailingListInterface $mailingList
 * @property string $receiversProviderAttribute
 */
class Mail extends \yz\db\ActiveRecord implements ModelInfoInterface
{
    const STATUS_NEW = 'new';
    const STATUS_WAITING = 'waiting';
    const STATUS_SENDING = 'sending';
    const STATUS_SENT = 'sent';
    const EVENT_SINGLE_MAIL_SENT = 'singleMailSent';
    const EVENT_MAIL_SENT = 'mailSent';

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
     * @return Module
     */
    protected static function getModule()
    {
        return Yii::$app->getModule('mailing');
    }

    public function init()
    {
        parent::init();
        if ($this->receivers_provider === null) {
            $this->receivers_provider = ManualMailList::className();
        }
        if ($this->receivers_provider_data === null) {
            $this->receivers_provider_data = '[]';
        }
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null,
                'value' => new Expression('NOW()'),
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivers_provider'], 'required'],
            [['body_html'], 'required'],
            [['body_html'], 'string'],
            [['from'], 'required'],
            [['from'], 'email'],
            [['from_name'], 'required'],
            [['subject'], 'required'],

            [['receivers_provider'], 'in', 'range' => array_keys(self::getReceiversProviderValues())],
            [['receiversProviderAttribute'], 'in', 'range' => array_keys(self::getReceiversProviderValues())],
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
            'receivers_provider' => Yii::t('admin/mailer', 'Receivers type'),
            'receiversProviderAttribute' => Yii::t('admin/mailer', 'Receivers type'),
            'receiver' => Yii::t('admin/mailer', 'Receiver'),
            'receiver_data' => Yii::t('admin/mailer', 'Receiver Data'),
            'from' => Yii::t('admin/mailer', 'From'),
            'from_name' => Yii::t('admin/mailer', 'From Name'),
            'subject' => Yii::t('admin/mailer', 'Subject'),
            'body_html' => Yii::t('admin/mailer', 'Body Html'),
            'created_at' => Yii::t('admin/mailer', 'Created At'),
            'last_sent_at' => Yii::t('admin/mailer', 'Sent At'),
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
    protected $_mailingList;

    /**
     * @return MailingListInterface
     */
    public function getMailingList()
    {
        $hash = md5($this->receivers_provider);
        if ($this->_mailingList === null) {
            $this->_mailingList = [Yii::createObject(array_merge([
                'class' => $this->receivers_provider,
            ], Json::decode($this->receivers_provider_data))), $hash];
        } elseif ($this->_mailingList[1] !== $hash) {
            $this->receivers_provider_data = [];
            $this->_mailingList = [Yii::createObject(array_merge([
                'class' => $this->receivers_provider,
            ], Json::decode($this->receivers_provider_data))), $hash];
        }

        return $this->_mailingList[0];
    }

    /**
     * @param array|string|MailingListInterface $mailingList
     * @throws \yii\base\InvalidConfigException
     */
    public function setMailingList($mailingList)
    {
        if (is_array($mailingList)) {
            $mailingList = Instance::ensure($mailingList, MailingListInterface::class);
        }

        if ($mailingList instanceof MailingListInterface) {
            $this->_mailingList = $mailingList;
            $this->receivers_provider = get_class($mailingList);
        } elseif (is_string($mailingList)) {
            $this->receivers_provider = $mailingList;
            $this->receivers_provider_data = '[]';
            $this->_mailingList = null;
        }
    }

    /**
     * @return string
     */
    public function getReceiversProviderAttribute()
    {
        return $this->receivers_provider;
    }

    /**
     * @param string $receiversProviderAttribute
     */
    public function setReceiversProviderAttribute($receiversProviderAttribute)
    {
        $this->setMailingList($receiversProviderAttribute);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function loadAll($data)
    {
        $result = $this->load($data);
        if ($this->mailingList instanceof Model) {
            $result = $this->mailingList->load($data) && $result;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function validateAll()
    {
        $result = $this->validate();
        if ($this->mailingList instanceof Model) {
            $result = $this->mailingList->validate() && $result;
        }
        return $result;
    }

    /**
     * @param bool $runValidation
     * @return bool
     */
    public function saveAll()
    {
        if ($this->validateAll() == false) {
            return false;
        }

        return $this->save(false);
    }

    public function beforeSave($insert)
    {
        $this->receivers_provider_data = Json::encode($this->mailingList->listData());

        if ($insert) {
            $this->status = self::STATUS_NEW;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public static function getReceiversProviderValues()
    {
        $values = [];
        foreach (self::getModule()->mailLists as $mailingList) {
            $values[$mailingList] = call_user_func([$mailingList, 'listTitle']);
        }
        return $values;
    }

    public function send()
    {
        $this->updateAttributes(['status' => self::STATUS_SENDING]);

        foreach ($this->mailingList->getRecipients() as $receiver) {
            $receiver->sendToRecipient($this);
            $this->trigger(self::EVENT_SINGLE_MAIL_SENT);
        }

        $this->updateAttributes([
            'status' => self::STATUS_SENT,
            'last_sent_at' => new Expression('NOW()'),
        ]);
        $this->trigger(self::EVENT_MAIL_SENT);
    }

    public function waitForSending()
    {
        $this->updateAttributes([
            'status' => self::STATUS_WAITING,
            'last_sent_at' => null,
        ]);
    }
}
