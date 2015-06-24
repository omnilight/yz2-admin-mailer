<?php

namespace yz\admin\mailer\common\lists;

use yii\base\Model;
use yz\admin\mailer\common\mailing\MailingListInterface;
use yz\admin\mailer\common\mailing\MailRecipientInterface;
use yz\admin\mailer\common\mailing\ManualRecipient;


/**
 * Class ManualMailList
 */
class ManualMailList extends Model implements MailingListInterface
{
    /**
     * @var string
     */
    public $to;

    /**
     * @return string
     */
    public static function formView()
    {
        return '@yz/admin/mailer/common/lists/views/manual.php';
    }

    /**
     * @return string
     */
    public static function listTitle()
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
    public function listData()
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
     * @return \Iterator|MailRecipientInterface[]
     */
    public function getRecipients()
    {
        $emails = preg_split('/\s*;\s*/', $this->to, -1, PREG_SPLIT_NO_EMPTY);
        $receivers = [];
        foreach ($emails as $email) {
            $receivers[] = new ManualRecipient([
                'email' => $this->to
            ]);
        }
        return new \ArrayIterator($receivers);
    }
}