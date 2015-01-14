<?php

namespace yz\admin\mailer\common\models;
use yii\helpers\ArrayHelper;


/**
 * Interface ReceiversProviderInterface
 * @property string $title
 */
interface ReceiversProviderInterface
{
    /**
     * @return string
     */
    public static function providerTitle();
    /**
     * @return array
     */
    public function getProviderData();

    /**
     * @return string
     */
    public static function backendFormView();
}