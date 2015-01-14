<?php

namespace yz\admin\mailer\common;
use yz\admin\mailer\common\models\ReceiversProviderInterface;
use yii\helpers\ArrayHelper;


/**
 * Class Module
 */
class Module extends \yz\Module
{
    /**
     * @var string[] Class names of the receiver providers
     */
    public $receiversProviders = [];

    public function init()
    {
        parent::init();

        $this->receiversProviders = ArrayHelper::merge([
            'yz\admin\mailer\common\models\ManualReceiverProvider',
        ], $this->receiversProviders);
    }


}