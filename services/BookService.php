<?php

namespace app\services;

use Yii;
use app\models\Book;
use app\repositories\BookRepository;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BookService
{
    private BookRepository $bookRepository;
    private SubscriptionService $subscriptionService;

    public function __construct()
    {
        $this->bookRepository = new BookRepository();
        $this->subscriptionService = new SubscriptionService();
    }

    /**
     * Finds book by id or throws exception.
     *
     * @throws NotFoundHttpException
     */
    public function findOrFail(int $id): Book
    {
        $model = $this->bookRepository->findById($id);

        if ($model === null) {
            throw new NotFoundHttpException('Book not found.');
        }

        return $model;
    }

    /**
     * Returns all books.
     */
    public function findAll(): array
    {
        return $this->bookRepository->findAll();
    }

    /**
     * Creates a new book with authors and notifies subscribers.
     */
    public function create(Book $model): bool
    {
        $model->photoFile = UploadedFile::getInstance($model, 'photoFile');

        if (!$model->save()) {
            return false;
        }

        $this->savePhotoFile($model);
        $this->saveAuthors($model);

        $this->subscriptionService->notifySubscribersAboutBook(
            $model->id,
            $model->title,
            (array) $model->author_ids
        );

        return true;
    }

    /**
     * Updates an existing book with authors.
     */
    public function update(Book $model): bool
    {
        $model->photoFile = UploadedFile::getInstance($model, 'photoFile');

        if (!$model->save()) {
            return false;
        }

        $this->savePhotoFile($model);
        $this->saveAuthors($model);

        return true;
    }
    /**
     * Deletes a book.
     */
    public function delete(Book $model): bool
    {
        return (bool) $model->delete();
    }

    /**
     * Saves the uploaded photo file.
     */
    private function savePhotoFile(Book $model): void
    {
        if ($model->photoFile === null) {
            return;
        }

        $photo = 'uploads/' . uniqid() . '.' . $model->photoFile->extension;
        $model->photoFile->saveAs(Yii::getAlias('@webroot') . '/' . $photo);
        $model->updateAttributes(['photo' => $photo]);
    }


    /**
     * Saves book-author relationships in junction table.
     */
    private function saveAuthors(Book $model): void
    {
        Yii::$app->db->createCommand()
            ->delete('book_author', ['book_id' => $model->id])
            ->execute();

        foreach ((array) $model->author_ids as $authorId) {
            Yii::$app->db->createCommand()
                ->insert('book_author', [
                    'book_id' => $model->id,
                    'author_id' => (int) $authorId,
                ])
                ->execute();
        }
    }
}
