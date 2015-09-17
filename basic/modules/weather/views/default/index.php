<section id="works" class="section">
    <div class="container">
        <div class="title col-md-12 col-sm-12 col-xs-12">
            <h1>НОВОСИБИРСК </h1>
            <p>Температура воздуха днём- последние 10 дней</p>
            <hr>
        </div>
            <?php
            $i = 0;
            foreach ($model as $rec) {
                $i++;
                $d = explode(' ',$rec->date);
                if($i%6 == 0) {
                    echo '  <div class="col-md-1 col-sm-6 col-xs-12"><p> ' . $rec->temp . '</p><p>' . $d[0] . '</p></div>';
                    echo '  <div class="col-md-1 col-sm-6 col-xs-12"><p> ' . $rec->temp . '</p><p>' . $d[0] . '</p></div>';
                    //$i--;
                }
                else
                    echo '  <div class="col-md-2 col-sm-6 col-xs-12"><p> '.$rec->temp . '</p><p>'. $d[0] .'</p></div>' ;
            }

            ?>


    </div>

</section>




