<?php

namespace app\controllers;

use Yii;
use app\repositories\AuthorRepository;
use yii\web\Controller;
use yii\filters\AccessControl;

class ReportController extends Controller
{
    private AuthorRepository $authorRepository;

    public function __construct($id, $module, $config = [])
    {
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
                        'actions' => ['top-authors'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays TOP 10 authors by book count for a given year.
     */
    public function actionTopAuthors(): string
    {
        $year = (int) Yii::$app->request->get('year', date('Y'));

        return $this->render('top-authors', [
            'authors' => $this->authorRepository->getTopByYear($year),
            'year' => $year,
        ]);
    }
}