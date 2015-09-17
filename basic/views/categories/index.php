<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
    <div class="col-sm-3 col-md-2 sidebar">
    <?php

    echo Nav::widget([
        'options' => ['class' => 'nav nav-sidebar'],
        'items' => [
            ['label' => 'Создать', 'url' => ['/categories/create']],
            ['label' => 'Редактировать', 'url' => ['/categories/update']],

        ],
    ]);

    ?>

    </div>

    <div class="col-sm-9 col-md-10 main">
            <h1 class="page-header">Категории</h1>


            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($cats as $cat) : ?>

                    <tr>
                        <td><?=$cat->title?></td>
                        <td><?=$cat->alias?></td>
                        <td><?=$cat->name?></td>
                        <td><?=$cat->lft?></td>
                        <td><?=$cat->rgt?></td>
                    </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
    </div>

