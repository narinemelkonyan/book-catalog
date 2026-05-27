<?php

namespace app\controllers;

use Yii;
use app\models\Subscription;
use app\services\SubscriptionService;
use yii\web\Controller;
use yii\filters\AccessControl;

class SubscriptionController extends Controller
{
    private SubscriptionService $subscriptionService;

    public function __construct($id, $module, $config = [])
    {
        $this->subscriptionService = new SubscriptionService();
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new subscription for a guest user.
     */
    public function actionCreate(int $author_id): string|\yii\web\Response
    {
        $author = $this->subscriptionService->findAuthorOrFail($author_id);

        $model = new Subscription();
        $model->author_id = $author_id;

        if ($model->load(Yii::$app->request->post()) && $this->subscriptionService->create($model)) {
            Yii::$app->session->setFlash('success', 'You have subscribed successfully!');
            return $this->redirect(['author/view', 'id' => $author_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'author' => $author,
        ]);
    }
}