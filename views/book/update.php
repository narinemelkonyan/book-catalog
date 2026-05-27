<?php
/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */

use yii\helpers\Html;

$this->title = 'Edit Book: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model, 'authors' => $authors]) ?>
