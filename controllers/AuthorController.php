<?php

namespace app\controllers;

use Yii;
use app\models\Author;
use app\services\AuthorService;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorController extends Controller
{
    private AuthorService $authorService;

    public function __construct($id, $module, $config = [])
    {
        $this->authorService = new AuthorService();
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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all authors.
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'authors' => $this->authorService->findAll(),
        ]);
    }

    /**
     * Displays a single author.
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->authorService->findOrFail($id),
        ]);
    }

    /**
     * Creates a new author.
     */
    public function actionCreate(): string|Response
    {
        $model = new Author();

        if ($model->load(Yii::$app->request->post()) && $this->authorService->create($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing author.
     */
    public function actionUpdate(int $id): string|Response
    {
        $model = $this->authorService->findOrFail($id);

        if ($model->load(Yii::$app->request->post()) && $this->authorService->update($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing author.
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): \yii\web\Response
    {
        $model = $this->authorService->findOrFail($id);

        try {
            $this->authorService->delete($model);
            Yii::$app->session->setFlash('success', 'Author deleted successfully.');
        } catch (\yii\base\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
