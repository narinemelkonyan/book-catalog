<?php
/** @var yii\web\View $this */
/** @var app\models\Book $model */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->user->can('user')): ?>
    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-method' => 'post',
            'data-confirm' => 'Are you sure?',
        ]) ?>
    </p>
<?php endif; ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'title',
        'year',
        'isbn',
        'description:ntext',
        [
            'label' => 'Authors',
            'value' => implode(', ', array_column($model->authors, 'full_name')),
        ],
        [
            'label' => 'Photo',
            'format' => 'html',
            'value' => $model->photo
                ? Html::img('@web/' . $model->photo, ['width' => 200])
                : 'No photo',
        ],
    ],
]) ?>
