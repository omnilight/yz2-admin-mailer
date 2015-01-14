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
     * @return array
     */
    public function getProviderData()
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

    /**
     * @return string
     */
    public static function providerTitle()
    {
        return \Yii::t('admin/mailer', 'Manual receiver');
    }
}