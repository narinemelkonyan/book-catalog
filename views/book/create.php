<?php
/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */

use yii\helpers\Html;

$this->title = 'Add Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model, 'authors' => $authors]) ?>