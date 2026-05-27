<?php
/** @var yii\web\View $this */
/** @var app\models\Author $model */

use yii\helpers\Html;

$this->title = 'Add Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', ['model' => $model]) ?>
