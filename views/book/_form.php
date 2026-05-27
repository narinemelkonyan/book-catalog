<?php
/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var app\models\Author[] $authors */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$authorList = ArrayHelper::map($authors, 'id', 'full_name');
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'year') ?>
<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
<?= $form->field($model, 'isbn') ?>
<?= $form->field($model, 'photoFile')->fileInput() ?>

<?php if ($model->photo): ?>
    <p><?= Html::img('@web/' . $model->photo, ['width' => 100]) ?></p>
<?php endif; ?>

<?php if (empty($authors)): ?>
    <div class="alert">
        No authors found. Please add an author.
    </div>
<?php else: ?>
    <?= $form->field($model, 'author_ids')->checkboxList($authorList) ?>
<?php endif; ?>

<div>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end() ?>
