/**
 * Created by Алексей on 07.11.2014.
 */

var TrafficCalculator = {
    init: function(settings) {
        this.initGenderBlock(settings.gender);
        this.initListingBlock(settings.region, settings.banner);
        this.initCheckboxRadioBlock(settings.days, settings.plattform, settings.paymentType, settings.VAT);
        $('#result-button', '#traffic-calculator').on('click', {basePrice: settings.basePrice}, this.calculate);
    },

    initGenderBlock: function(genderListing) {
        var parentElem = $('#gender-block'),
            newHtml = '', tempElem = '';

        for (var i = 0; i < genderListing.length; i++) {
            if (i == genderListing.length - 1) {
                if (genderListing[i].selected) {
                    tempElem = '<div class="selected last" data-rate=' + genderListing[i].rate + '>';
                } else {
                    tempElem = '<div class="last" data-rate=' + genderListing[i].rate + '>';
                }
            } else {
                if (genderListing[i].selected) {
                    tempElem = '<div class="selected" data-rate=' + genderListing[i].rate + '>';
                } else {
                    tempElem = '<div data-rate=' + genderListing[i].rate + '>';
                }
            }

            tempElem += genderListing[i].alias + '</div>';
            newHtml += tempElem;
        }

        parentElem.html(newHtml);
        parentElem.find('div').on('click', this.genderBlockClick);
    },

    initListingBlock: function() {
        var parentElem = $('#region-block'),
            newHtml = '', tempElem = '';

        for (var i = 0; i < arguments.length; i++) {
            newHtml = '';
            if (i == arguments.length - 1) {
                parentElem = $('#banner-block');
            }
            var selected = false;
            for (var j = 0; j < arguments[i].length; j++) {
                if (arguments[i][j].selected && !selected) {
                    parentElem.find('div.selected-item').html('<i></i>' + arguments[i][j].alias);
                    tempElem = '<li class="selected" style="height:0px;" data-rate=' + arguments[i][j].rate + '>';
                    selected = true;
                } else {
                    tempElem = '<li data-rate=' + arguments[i][j].rate + '>';
                }

                tempElem += arguments[i][j].alias + '</li>';
                newHtml += tempElem;
            }
            parentElem.find('ul').html(newHtml);
            if (arguments[i].length <= 5) {
                parentElem.find('div.flexcroll').css('height', 46 * (arguments[i].length - 1) + 'px')
            } else {
                parentElem.find('div.flexcroll').css('height', '230px')
            }

            parentElem.find('div.selected-item').on('click', this.listingClick);
            parentElem.find('ul li').on('click', this.listItemClick);
        }
    },

    initCheckboxRadioBlock: function() {
        var parentElem = $('#days-block'),
            newHtml = '', tempElem = '';

        for (var i = 0; i < arguments.length; i++) {
            newHtml = '';
            for (var j = 0; j < arguments[i].length; j++) {
                if (i == arguments[i].length - 1) {
                    if (arguments[i][j].selected) {
                        tempElem = '<div class="selected" data-rate=' + arguments[i][j].rate + '><i></i>';
                    } else {
                        tempElem = '<div data-rate=' + arguments[i][j].rate + '><i></i>';
                    }
                } else {
                    if (arguments[i][j].selected) {
                        tempElem = '<div class="selected" data-rate=' + arguments[i][j].rate + '><i></i>';
                    } else {
                        tempElem = '<div data-rate=' + arguments[i][j].rate + '><i></i>';
                    }
                }

                tempElem += arguments[i][j].alias + '</div>';
                newHtml += tempElem;
            }

            if (i == 1) {
                parentElem = $('#plattform-block');
                parentElem.html(newHtml);
            } else if (i == 2) {
                parentElem = $('#payment-type');
                parentElem.html(newHtml);
            } else if (i == 3) {
                parentElem = $('#VAT');
                parentElem.html(newHtml);
            } else {
                parentElem.html(newHtml);
            }

            if (i == 1 || i == 0) {
                parentElem.find('div').on('mousedown', this.checkBoxMouseDown);
                parentElem.find('div').on('click', this.checkBoxClick);
            } else {
                parentElem.find('div').on('mousedown', this.radioButtonMouseDown);
                parentElem.find('div').on('click', this.radioButtonClick);
            }
        }
    },

    genderBlockClick: function(){
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            $(this).addClass('selected');
        }
    },

    listingClick: function() {
        var thisElem = $(this),
            flexscroll = thisElem.parents('.listing-block').find('div.flexcroll');
        if (flexscroll.css('z-index') != '-1') {
            flexscroll.slideUp(200, function(){
                flexscroll.css({'z-index': '-1'});
            });
        } else {
            flexscroll.css({'z-index': '1', 'display': 'none'});
            flexscroll.slideDown(200);
            thisElem.parents('.listing-block').find('ul li').css({'display': 'block', 'height': '46px'});
            thisElem.parents('.listing-block').find('ul li.selected').css('display', 'none');
            $('body').on('click', function(ev) {
                if ($(ev.target).hasClass('flexcroll') ||
                    $(ev.target).parents('.flexcroll').index() != -1) {
                    $('body').off('click');
                } else {
                    flexscroll.slideUp(200, function(){
                        flexscroll.css({'z-index': '-1'});
                    });
                    $('body').off('click');
                }
            });
        }
        return false;
    },

    listItemClick: function() {
        var listItem = $(this);
        listItem.parent().find('li').removeClass('selected');
        listItem.addClass('selected');
        listItem.parents('.flexcroll').slideUp(200, function(){
            listItem.parents('.flexcroll').css({'z-index': '-1'});
        });
        listItem.parents('.listing-block').find('div.selected-item').html('<i></i>' + listItem.text());
    },

    checkBoxMouseDown: function() {
        var thisElem = $(this);
        thisElem.find('i').css('background-position', '0 -38px');
        $('body').on('mouseup', function(event) {
            if (thisElem.parent().attr('id') != $(event.target).parent().attr('id') ||
                    thisElem.attr('id') != $(event.target).attr('id')) {
                thisElem.find('i').css('background-position', '');
                $('body').off('mouseup');
                return false;
            }

            $('body').off('mouseup');
        });
    },

    checkBoxClick: function() {
        $(this).find('i').css('background-position', '');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected')
        } else {
            $(this).addClass('selected')
        }
    },

    radioButtonMouseDown: function() {
        var thisElem = $(this);
        $(thisElem).find('i').css('background-position', '0 -108px');
        $('body').on('mouseup', function(event) {
            if (thisElem.parent().attr('id') != $(event.target).parent().attr('id') ||
                thisElem.attr('id') != $(event.target).attr('id')) {
                $(thisElem).find('i').css('background-position', '');
                $('body').off('mouseup');
                return false;
            }

            $('body').off('mouseup');
        });
    },

    radioButtonClick: function() {
        $(this).parent()
            .find('div')
            .removeClass('selected')
            .find('i')
            .css('background-position', '');

        $(this).find('i').css('background-position', '');
        $(this).addClass('selected');
    },

    calculate: function(event) {
        var selectedGender = $('#gender-block').find('div.selected'),
            selectedRegion = $('#region-block').find('li.selected').attr('data-rate'),
            selectedDays = $('#days-block').find('div.selected'),
            selectedBanner = $('#banner-block').find('li.selected').attr('data-rate'),
            selectedPlattform = $('#plattform-block').find('div.selected'),
            selectedPaymentType = $('#payment-type').find('div.selected').attr('data-rate'),
            selectedVAT = $('#VAT').find('div.selected').attr('data-rate'),
            basePrice = event.data.basePrice,
            result = 0;

        for (var i = 0; i < selectedGender.length; i++) {
            result += +selectedGender.eq(i).attr('data-rate');
        }

        result += +selectedRegion;

        for (var i = 0; i < selectedDays.length; i++) {
            result += +selectedDays.eq(i).attr('data-rate');
        }

        result += +selectedBanner;

        for (var i = 0; i < selectedPlattform.length; i++) {
            result += +selectedPlattform.eq(i).attr('data-rate');
        }

        result += +selectedPaymentType + +selectedVAT;
        result = Math.floor(result * +basePrice);
        $('#modal-form').find('p strong').text(result);

        $('#overlay').fadeIn(400,
            function() {
                $('#modal-form')
                    .css('display', 'block')
                    .animate({opacity: 1}, 200);
        });

        $('#modal_close, #overlay').on('click', function() {
            $('#modal-form').animate({opacity: 0}, 200,
                function() {
                    $(this).css('display', 'none');
                    $('#overlay').fadeOut(400);
                    $('#modal_close, #overlay').off('click');
                }
            );
        });
    }
};

TrafficCalculator.init(calculatorSettings);

