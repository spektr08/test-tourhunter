<?php

use yii\db\Migration;

/**
 * Handles the creation of table `balance`.
 */
class m171018_064537_create_balance_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        
        $this->createTable('balance', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'balance' => $this->double()
            
        ]);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('balance');
    }
}
