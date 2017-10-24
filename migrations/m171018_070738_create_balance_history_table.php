<?php

use yii\db\Migration;

/**
 * Handles the creation of table `balance_history`.
 */
class m171018_070738_create_balance_history_table extends Migration
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
        
        
        $this->createTable('balance_history', [
            'id' => $this->primaryKey(),
            'user_id_from' => $this->integer(),
            'user_id_to' => $this->integer(),
            'balance' => $this->double(),
            'date' => $this->timestamp()->notNull(),
        ]);
        
        
       // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_id-from',
            'balance_history',
            'user_id_from',
            'user',
            'id',
            'CASCADE'
        ); 
        
        
        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_id-to',
            'balance_history',
            'user_id_to',
            'user',
            'id',
            'CASCADE'
        ); 
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('balance_history');
    }
}
