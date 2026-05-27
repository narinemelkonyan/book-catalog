<?php

use yii\db\Migration;

class m260526_164246_add_unique_subscription_author_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-subscription-author-phone-unique',
            'subscription',
            ['author_id', 'phone'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-subscription-author-phone-unique',
            'subscription'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260526_164246_add_unique_subscription_author_phone cannot be reverted.\n";

        return false;
    }
    */
}
