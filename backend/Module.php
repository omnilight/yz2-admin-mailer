<?php

namespace yz\admin\mailer\backend;


/**
 * Class Module
 */
class Module extends \yz\admin\mailer\common\Module
{
    public function getName()
    {
        return \Yii::t('admin/mailer', 'Mailing module');
    }

}