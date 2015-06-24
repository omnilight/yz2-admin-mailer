<?php

namespace yz\admin\mailer;

use omnilight\scheduling\Schedule;
use yii\base\Application;
use yii\base\BootstrapInterface;


/**
 * Class Bootstrap
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->i18n->translations['admin/mailer'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yz/admin/mailer/common/messages',
            'sourceLanguage' => 'en-US',
        ];

        if ($app instanceof \yii\console\Application) {
            $app->params['yii.migrations'][] = '@yz/admin/mailer/migrations';
        }
    }
}