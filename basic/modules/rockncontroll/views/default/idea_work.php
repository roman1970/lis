
<style>
    .center, h3, table > tbody > tr > td{
        text-align: center;
    }
    .table > tbody > tr > td{
        vertical-align: middle;
        font-size: 15px;
        color: rgb(255, 215, 0);
    }
    h3{
        color: rgb(255, 215, 0);
    }


    .form-control {
        width: 100%;
    }


</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-event">
        <div class="form-group">
            <h3>Редактировать идею</h3>
            <p>
                <input type="text" class="form-control" id="cat"  placeholder="<?=$idea->title?>">
                <textarea class="form-control" id="text" rows="10" cols="45"><?=$idea->text?></textarea>
                <br>
                <button type="button" class="btn btn-success" id="rec_event" >Записать!</button>
            </p>
            <div id="res"></div>


        </div>
    </form>

</div>
