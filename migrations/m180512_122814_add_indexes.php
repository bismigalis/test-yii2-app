<?php

use yii\db\Migration;

/**
 * Class m180512_122814_add_indexes
 */
class m180512_122814_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-orders-status-service_id-mode',
            'orders',
            ['status', 'service_id', 'mode']
        );
        $this->createIndex(
            'idx-orders-status-mode',
            'orders',
            ['status', 'mode']
        );
        $this->createIndex(
            'idx-orders-service_id-mode',
            'orders',
            ['service_id', 'mode']
        );
        $this->createIndex(
            'idx-orders-mode',
            'orders',
            'mode'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180512_122814_add_indexes cannot be reverted.\n";
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180512_122814_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
