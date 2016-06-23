<script>
    var bounce = new Bounce();
    bounce.rotate({
        from: 0,
        to: 90
    });

    bounce.applyTo(document.querySelectorAll(".balll"));
</script>
<div class="col-sm-4 col-md-3 sidebar" xmlns="http://www.w3.org/1999/html">


</div>

<div class="col-sm-8 col-md-9 main">
    <h1 class="page-header">Твои прогнозы</h1>
     <?php
        foreach ($predicted as $one) {
            var_dump($one);
        }
     ?>

    </div>


