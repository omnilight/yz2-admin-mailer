<?php

namespace yz\admin\mailer\common\models;
use yii\helpers\ArrayHelper;


/**
 * Interface MailReceiverProviderInterface
 */
interface MailReceiverProviderInterface
{
    /**
     * @return array
     */
    public function getReceiversProviderData();

    /**
     * @return string
     */
    public static function backendFormView();
}