<?php

namespace app\repositories;

use app\models\Book;

class BookRepository
{
    /**
     * Returns all books with authors.
     */
    public function findAll(): array
    {
        return Book::find()->with('authors')->all();
    }

    /**
     * Finds book by primary key.
     */
    public function findById(int $id): ?Book
    {
        return Book::find()->with('authors')->where(['id' => $id])->one();
    }
}
