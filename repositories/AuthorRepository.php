<?php

namespace app\repositories;

use Yii;

namespace app\repositories;

use app\models\Author;
use yii\db\Query;

class AuthorRepository
{
    /**
     * Returns all authors.
     */
    public function findAll(): array
    {
        return Author::find()->all();
    }

    /**
     * Finds author by primary key.
     */
    public function findById(int $id): ?Author
    {
        return Author::findOne($id);
    }

    /**
     * Returns TOP 10 authors by book count for a given year.
     */
    public function getTopByYear(int $year): array
    {
        return (new Query())
            ->select(['a.id', 'a.full_name', 'COUNT(b.id) as book_count'])
            ->from('author a')
            ->innerJoin('book_author ba', 'ba.author_id = a.id')
            ->innerJoin('book b', 'b.id = ba.book_id')
            ->where(['b.year' => $year])
            ->groupBy(['a.id', 'a.full_name'])
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}
