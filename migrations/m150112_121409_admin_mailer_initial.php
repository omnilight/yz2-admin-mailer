<?php

use yii\db\Schema;
use yii\db\Migration;

class m150112_121409_admin_mailer_initial extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'ENGINE=InnoDB CHARSET=utf8';
        }

        $this->createTable('{{%admin_mails}}', [
            'id' => Schema::TYPE_PK,
            'status' => Schema::TYPE_STRING.'(16)',
            'receivers_provider' => Schema::TYPE_STRING,
            'receivers_provider_data' => Schema::TYPE_TEXT,
            'from' => Schema::TYPE_STRING,
            'from_name' => Schema::TYPE_STRING,
            'subject' => Schema::TYPE_STRING,
            'body_html' => Schema::TYPE_TEXT,
            'boxy_text' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_DATETIME,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%admin_mails}}');
    }
}
