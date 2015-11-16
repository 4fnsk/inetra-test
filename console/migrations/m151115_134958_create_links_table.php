<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_134958_create_links_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%links}}', [
            'from' => $this->integer()->notNull(),
            'to' => $this->integer()->notNull(),
            'order' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('links_pk', '{{%links}}', [
            'from',
            'to'
        ]);

        $this->addForeignKey('linkfrom', '{{%links}}', 'from', '{{%items}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('linkto', '{{%links}}', 'to', '{{%items}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('linkfrom', '{{%links}}');
        $this->dropForeignKey('linkto', '{{%links}}');
        $this->dropTable('{{%links}}');
    }

}
