<?php

namespace yz\admin\mailer\common\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;


/**
 * Class ManualReceiverProvider
 */
class ManualReceiverProvider extends Model implements MailReceiverProviderInterface
{
    /**
     * @var string
     */
    public $to;

    /**
     * @return array
     */
    public function getReceiversProviderData()
    {
        return [
            'to' => $this->to,
        ];
    }

    /**
     * @return string
     */
    public static function backendFormView()
    {
        return '@yz/admin/mailer/backend/views/receiversProviders/manual.php';
    }
}