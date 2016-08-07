<script>
    $(document).ready(function() {

        $('#dish').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                term = term.toLowerCase();
                $.getJSON("dishes", function (data) {
                    console.log(data);
                    choices = data;
                    var suggestions = [];
                    for (i = 0; i < choices.length; i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);

                }, "json");

            }
        });

    });
    
    
</script>

<style>
    .center{
        text-align: center;
    }
</style>

<div class="container">
    <form class="form-inline center" role="form" id="form-ate">
        <div class="form-group">
            <h3>Что съел?</h3>
            <p>
                <input type="text" class="form-control" id="dish"  placeholder="Выбрать блюдо">
                <input type="text" class="form-control" id="measure"  placeholder="Съеденное в граммах">
               
                <?php /*<button type="button" class="btn btn-success" id="two_teams" >Поиск</button></p> */ ?>
                <button type="button" class="btn btn-success" id="ate" >Записать</button>
            </p>
        </div>
    </form>
</div> 