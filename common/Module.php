<?php

namespace yz\admin\mailer\common;
use yii\helpers\ArrayHelper;
use yz\admin\mailer\common\lists\ManualMailList;


/**
 * Class Module
 */
class Module extends \yz\Module
{
    /**
     * @var string[] Mail lists
     */
    public $mailLists = [];

    public function init()
    {
        parent::init();

        $this->mailLists = ArrayHelper::merge([
            ManualMailList::class,
        ], $this->mailLists);
    }


}