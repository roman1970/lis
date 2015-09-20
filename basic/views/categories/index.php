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
            ['label' => 'Создать главную категорию', 'url' => ['/categories/create']],
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
                        <td>  <a class="edit" href="update?id=<?=$cat->id?>&type=1" title="редактировать"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="del" href="delete?id=<?=$cat->id?>&type=1" title="удалить"><span class="glyphicon glyphicon-remove"></span></a></td>
                    </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
    </div>

