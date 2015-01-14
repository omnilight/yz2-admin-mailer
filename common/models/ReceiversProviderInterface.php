<?php

namespace yz\admin\mailer\common\models;
use yii\helpers\ArrayHelper;


/**
 * Interface ReceiversProviderInterface
 * @property \Iterator|MailReceiverInterface[] $receivers
 * @property bool $canSendImmediately
 * @property array $providerData Provider data that should be stored into the database
 */
interface ReceiversProviderInterface
{
    /**
     * Title for the current provider
     * @return string
     */
    public static function providerTitle();
    /**
     * Provider data that should be stored into the database
     * @return array
     */
    public function getProviderData();
    /**
     * Path for the view
     * @return string
     */
    public static function backendFormView();
    /**
     * @return \Iterator|MailReceiverInterface[]
     */
    public function getReceivers();
    /**
     * Returns true if it is possible to send mails immediately. Otherwise they will be sent
     * via cron job
     * @return bool
     */
    public function getCanSendImmediately();
}