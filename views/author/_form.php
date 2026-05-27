<?php
/** @var yii\web\View $this */
/** @var app\models\Author $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'full_name') ?>

<div>
    <?= Html::submitButton(
        $model->isNewRecord ? 'Create' : 'Save',
        ['class' => 'btn btn-success']
    ) ?>
</div>

<?php ActiveForm::end() ?>
