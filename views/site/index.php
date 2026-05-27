<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Book catalog';
?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Book catalog</h1>

        <p class="mt-4">
            <?= Html::a(
                    'Top authors report',
                    ['report/top-authors'],
                    ['class' => 'btn btn-primary']
            ) ?>
        </p>
    </div>

</div>