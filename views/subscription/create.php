<?php
/** @var yii\web\View $this */
/** @var app\models\Subscription $model */
/** @var app\models\Author $author */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subscribe to ' . $author->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/author/index']];
$this->params['breadcrumbs'][] = ['label' => $author->full_name, 'url' => ['/author/view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Subscribe';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Enter your phone number to receive SMS notifications when a new book by <?= Html::encode($author->full_name) ?> is added.</p>

<?php $form = ActiveForm::begin() ?>

<?= $form->errorSummary($model) ?>

<?= $form->field($model, 'phone') ?>

<div>
    <?= Html::submitButton('Subscribe', ['class' => 'btn btn-info']) ?>
</div>

<?php ActiveForm::end() ?>
