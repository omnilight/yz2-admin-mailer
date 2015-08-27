<?php

use yii\db\Migration;

class m150827_125909_admin_mailer_change_receiver_name extends Migration
{
    public function up()
    {
        $this->update('{{%admin_mails}}',
            [
                'receivers_provider' => 'yz\admin\mailer\common\lists\ManualMailList'
            ],
            [
                'receivers_provider' => 'yz\admin\mailer\common\models\ManualReceiverProvider',
            ]
        );
    }

    public function down()
    {
        $this->update('{{%admin_mails}}',
            [
                'receivers_provider' => 'yz\admin\mailer\common\models\ManualReceiverProvider'
            ],
            [
                'receivers_provider' => 'yz\admin\mailer\common\lists\ManualMailList',
            ]
        );
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
