$(document).ready(function() {
    var main = $('#main');
    main.on('mouseover', function() {
        $('ul', this).show();

        $(document).on('mouseout.showMenu', function(event) {
            if (main.find($(event.target)).length === 0) {
                main.find('ul').hide();
                $(document).off('mouseout.showMenu');
            }
        });
    });

});