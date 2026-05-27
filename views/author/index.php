<?php
/** @var yii\web\View $this */
/** @var app\models\Author[] $authors */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->user->can('user')): ?>
    <p><?= Html::a('Add Author', ['create'], ['class' => 'btn btn-success']) ?></p>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $authors,
        'key' => 'id',
        'pagination' => ['pageSize' => 20],
    ]),
    'columns' => [
        'id',
        'full_name',
        [
            'class' => ActionColumn::class,
            'template' => Yii::$app->user->can('user') ? '{view} {update} {delete}' : '{view}',
        ],
    ],
]) ?>
