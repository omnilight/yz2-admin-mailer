<?php

namespace yz\admin\mailer\backend;
use yz\icons\Icons;


/**
 * Class Module
 */
class Module extends \yz\admin\mailer\common\Module
{
    public function getName()
    {
        return \Yii::t('admin/mailer', 'Mailing module');
    }

    public function getAdminMenu()
    {
        return [
            [
                'label' => \Yii::t('admin/mailer', 'Sending emails'),
                'icon' => Icons::o('envelope'),
                'items' => [
                    [
                        'label' => \Yii::t('admin/mailer', 'Send mails'),
                        'icon' => Icons::o('envelope-o'),
                        'route' => ['/mailing/mails/index'],
                    ],
                ],
            ],
        ];
    }
}