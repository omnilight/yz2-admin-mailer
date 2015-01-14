<?php

use yii\db\Schema;
use yii\db\Migration;

class m150114_142728_admin_mailer_add_sent_at extends Migration
{
    public function up()
    {
        $this->addColumn('{{%admin_mails}}', 'last_sent_at', Schema::TYPE_DATETIME);
    }

    public function down()
    {
        $this->dropColumn('{{%admin_mails}}', 'last_sent_at');
    }
}
