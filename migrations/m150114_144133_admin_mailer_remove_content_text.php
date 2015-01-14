<?php

use yii\db\Schema;
use yii\db\Migration;

class m150114_144133_admin_mailer_remove_content_text extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%admin_mails}}', 'boxy_text');
    }

    public function down()
    {
        echo "m150114_144133_admin_mailer_remove_content_text cannot be reverted.\n";

        return false;
    }
}
