<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\repositories\AuthorRepository;
use app\services\BookService;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookController extends Controller
{
    private BookService $bookService;
    private AuthorRepository $authorRepository;

    public function __construct($id, $module, $config = [])
    {
        $this->bookService = new BookService();
        $this->authorRepository = new AuthorRepository();
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
     * Lists all books.
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'books' => $this->bookService->findAll(),
        ]);
    }

    /**
     * Displays a single book.
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->bookService->findOrFail($id),
        ]);
    }

    /**
     * Creates a new book.
     */
    public function actionCreate(): string|Response
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $this->bookService->create($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'authors' => $this->authorRepository->findAll(),
        ]);
    }

    /**
     * Updates an existing book.
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): string|Response
    {
        $model = $this->bookService->findOrFail($id);
        $model->author_ids = array_column($model->authors, 'id');

        if ($model->load(Yii::$app->request->post()) && $this->bookService->update($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'authors' => $this->authorRepository->findAll(),
        ]);
    }

    /**
     * Deletes an existing book.
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $this->bookService->delete(
            $this->bookService->findOrFail($id)
        );

        return $this->redirect(['index']);
    }
}
