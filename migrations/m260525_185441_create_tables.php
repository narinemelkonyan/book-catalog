<?php

use yii\db\Migration;

class m260525_185441_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull(),
        ]);

        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer(4)->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(20)->unique(),
            'photo' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('book_author', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'PRIMARY KEY(book_id, author_id)',
        ]);

        $this->addForeignKey('fk_book_author_book', 'book_author', 'book_id', 'book', 'id', 'CASCADE');
        $this->addForeignKey('fk_book_author_author', 'book_author', 'author_id', 'author', 'id', 'CASCADE');

        $this->createTable('subscription', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_subscription_author', 'subscription', 'author_id', 'author', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_subscription_author', 'subscription');
        $this->dropForeignKey('fk_book_author_author', 'book_author');
        $this->dropForeignKey('fk_book_author_book', 'book_author');

        $this->dropTable('subscription');
        $this->dropTable('book_author');
        $this->dropTable('book');
        $this->dropTable('author');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260525_185441_create_tables cannot be reverted.\n";

        return false;
    }
    */
}
