<?php
/** @var yii\web\View $this */
/** @var array $authors */
/** @var int $year */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;

$this->title = 'TOP 10 Authors';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?php $form = \yii\widgets\ActiveForm::begin(['method' => 'get']) ?>
    <?= Html::label('Year', 'year') ?>
    <?= Html::input('number', 'year', $year, ['id' => 'year', 'min' => 1900, 'max' => date('Y')]) ?>
    <?= Html::submitButton('Show', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</p>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $authors,
        'pagination' => false,
    ]),
    'columns' => [
        [
            'label' => '#',
            'value' => function ($model, $key, $index) {
                return $index + 1;
            },
        ],
        [
            'label' => 'Author',
            'value' => function ($model) {
                return Html::a(
                    Html::encode($model['full_name']),
                    ['/author/view', 'id' => $model['id']]
                );
            },
            'format' => 'html',
        ],
        [
            'label' => 'Books in ' . $year,
            'value' => 'book_count',
        ],
    ],
]) ?>
