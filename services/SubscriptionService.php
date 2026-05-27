<?php

namespace app\services;

use app\models\Book;
use app\models\Subscription;
use app\repositories\AuthorRepository;
use app\repositories\SubscriptionRepository;
use yii\web\NotFoundHttpException;

class SubscriptionService
{
    private AuthorRepository $authorRepository;
    private SubscriptionRepository $subscriptionRepository;
    private SmsService $smsService;

    public function __construct()
    {
        $this->authorRepository = new AuthorRepository();
        $this->subscriptionRepository = new SubscriptionRepository();
        $this->smsService = new SmsService();
    }

    /**
     * Creates a new subscription for a guest.
     */
    public function create(Subscription $model): bool
    {
        return $model->save();
    }

    /**
     * Notifies all subscribers of the book's authors via SMS.
     */
    public function notifySubscribersAboutBook(int $bookId, string $bookTitle, array $authorIds): void
    {
        $subscriptions = $this->subscriptionRepository->findByAuthorIds($authorIds);

        foreach ($subscriptions as $subscription) {
            $this->smsService->send(
                $subscription->phone,
                "New book: \"{$bookTitle}\" by {$subscription->author->full_name}."
            );
        }
    }

    /**
     * Finds author or throws exception.
     *
     * @throws NotFoundHttpException
     */
    public function findAuthorOrFail(int $authorId): \app\models\Author
    {
        $author = $this->authorRepository->findById($authorId);

        if ($author === null) {
            throw new NotFoundHttpException('Author not found.');
        }

        return $author;
    }
}