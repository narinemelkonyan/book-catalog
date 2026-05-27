<?php
/** @var yii\web\View $this */
/** @var app\models\Author $model */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
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
        'full_name',
    ],
]) ?>

<h2>Books</h2>

<?php if ($model->books): ?>
    <ul>
        <?php foreach ($model->books as $book): ?>
            <li><?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?> (<?= $book->year ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No books yet.</p>
<?php endif; ?>

<?php if (Yii::$app->user->isGuest): ?>
    <p><?= Html::a('Subscribe to this author', ['/subscription/create', 'author_id' => $model->id], ['class' => 'btn btn-info']) ?></p>
<?php endif; ?>

