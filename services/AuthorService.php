<?php

namespace app\services;

use app\models\Author;
use app\repositories\AuthorRepository;
use yii\web\NotFoundHttpException;

class AuthorService
{
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->authorRepository = new AuthorRepository();
    }

    /**
     * Finds author by id or throws exception.
     *
     * @throws NotFoundHttpException
     */
    public function findOrFail(int $id): Author
    {
        $model = $this->authorRepository->findById($id);

        if ($model === null) {
            throw new NotFoundHttpException('Author not found.');
        }

        return $model;
    }

    /**
     * Returns all authors.
     */
    public function findAll(): array
    {
        return $this->authorRepository->findAll();
    }

    /**
     * Creates a new author.
     */
    public function create(Author $model): bool
    {
        return $model->save();
    }

    /**
     * Updates an existing author.
     */
    public function update(Author $model): bool
    {
        return $model->save();
    }

    /**
     * Deletes an author.
     */
    public function delete(Author $model): bool
    {
        if (!empty($model->books)) {
            throw new \yii\base\Exception('Cannot delete author with books.');
        }
        return (bool) $model->delete();
    }
}