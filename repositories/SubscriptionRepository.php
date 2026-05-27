<?php

namespace app\repositories;

use app\models\Subscription;

class SubscriptionRepository
{
    /**
     * Finds subscriptions by author ids.
     */
    public function findByAuthorIds(array $authorIds): array
    {
        return Subscription::find()
            ->with('author')
            ->where(['author_id' => $authorIds])
            ->all();
    }
}