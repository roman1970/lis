<?php

use app\assets\Russia2018Asset;
use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

Russia2018Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <link href="css/flags.css" rel="stylesheet">
        <? /* тестирование js функции pow
        <script src="https://js.cx/test/libs.js"></script>
        <script type="application/javascript">
            describe("pow", function() {

                describe("возводит x в степень n", function() {

                    function makeTest(x) {
                        var expected = x * x * x;
                        it("при возведении " + x + " в степень 3 результат: " + expected, function() {
                            assert.equal(pow(x, 3), expected);
                        });
                    }

                    for (var x = 1; x <= 5; x++) {
                        makeTest(x);
                    }

                });

                it("при возведении в отрицательную степень результат NaN", function() {
                    assert(isNaN(pow(2, -1)), "pow(2, -1) не NaN");
                });

                it("при возведении в дробную степень результат NaN", function() {
                    assert(isNaN(pow(2, 1.5)), "pow(2, -1.5) не NaN");
                });

            });
        </script>
        */?>

        <?php $this->head() ?>
    </head>

    <body>
        <?php /*
            <script>

                function pow(x, n) {
                    if (n < 0) return NaN;
                    if (Math.round(n) != n) return NaN;

                    var result = 1;
                    for (var i = 0; i < n; i++) {
                        result *= x;
                    }
                    return result;
                }

            </script>
         */ ?>
    <canvas id="planet" width="285" height="285" style="position: absolute; left:200px; top: 200px; border-radius:50%">
    </canvas>
    <?php $this->beginBody() ?>
    <?= $content ?>


    <?php $this->endBody() ?>
        </body>
</html>
<?php $this->endPage() ?>
