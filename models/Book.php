<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book';
    }

    public $photoFile = null;

    public $author_ids = [];

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
            [['title', 'year', 'isbn'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['year'], 'integer', 'min' => 1000, 'max' => 2026],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            [['photo'], 'string', 'max' => 255],
            [['photoFile'], 'file', 'extensions' => 'jpg,jpeg,png,gif,webp', 'skipOnEmpty' => true],
            [['author_ids'], 'required', 'message' => 'Please select at least one author.'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'ISBN',
            'photo' => 'Photo',
            'author_ids' => 'Authors',
        ];
    }

    /**
     * Gets all authors of this book via book_author junction table.
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }
}
