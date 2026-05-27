<?php
/** @var yii\web\View $this */
/** @var app\models\Book[] $books */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->user->can('user')): ?>
    <p><?= Html::a('Add Book', ['create'], ['class' => 'btn btn-success']) ?></p>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $books,
        'key' => 'id',
        'pagination' => ['pageSize' => 20],
    ]),
    'columns' => [
        'id',
        'title',
        'year',
        'isbn',
        [
            'label' => 'Authors',
            'value' => function ($model) {
                return implode(', ', array_column($model->authors, 'full_name'));
            },
        ],
        [
            'class' => ActionColumn::class,
            'template' => Yii::$app->user->can('user') ? '{view} {update} {delete}' : '{view}',
        ],
    ],
]) ?>

