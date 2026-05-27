<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Subscription extends ActiveRecord
{
    /** @inheritdoc */
    public static function tableName(): string
    {
        return 'subscription';
    }

    /** @inheritdoc */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /** @inheritdoc */
    public function rules(): array
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^\+?[0-9]{10,15}$/'],
            [['author_id'], 'exist', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            [
                ['author_id', 'phone'],
                'unique',
                'targetAttribute' => ['author_id', 'phone'],
                'message' => 'This author is already subscribed with this phone number.'
            ],
            ];
    }

    /** @inheritdoc */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author',
            'phone' => 'Phone Number',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets the author this subscription belongs to.
     */
    public function getAuthor(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}