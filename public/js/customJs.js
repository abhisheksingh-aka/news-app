$(window).scroll(function () {
    if ($(window).scrollTop() > 63) {
        $('.navbar').addClass('navbar-fixed');
    }
    if ($(window).scrollTop() < 64) {
        $('.navbar').removeClass('navbar-fixed');
    }
});



$(document).off('change', "#language_set").on('change', "#language_set", function (e) {
    $('#language_set_form').submit(); //.trigger('submit');
});


$(document).off('click', '#terms_service').on('click', '#terms_service', function (e) {
    $('#terms_service_popup').modal("show");
});

$(document).off('click', '#privacy_policy').on('click', '#privacy_policy', function (e) {
    $('#privacy_policy_popup').modal("show");
});

$(document).off('click', '#cookies').on('click', '#cookies', function (e) {
    $('#cookies_popup').modal("show");
});

$(document).off('keydown',".validate_number").on('keydown',".validate_number",function (e){
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});


function createAuto (i, elem) {
    var input = $(elem);
    var dropdown = input.closest('.dropdown');
    var menu = dropdown.find('.dropdown-menu');
    var listContainer = dropdown.find('.list-autocomplete');
    var listItems = listContainer.find('.dropdown-item');
    var hasNoResults = dropdown.find('.hasNoResults');

    listItems.hide();
    listItems.each(function() {
        $(this).data('value', $(this).text() );
        //!important, keep this copy of the text outside of keyup/input function
    });

    input.on("input", function(e){

        if((e.keyCode ? e.keyCode : e.which) == 13)  {
            $(this).closest('.dropdown').removeClass('open').removeClass('in');
            return; //if enter key, close dropdown and stop
        }
        if((e.keyCode ? e.keyCode : e.which) == 9) {
            return; //if tab key, stop
        }


        var query = input.val().toLowerCase();
        if( query.length > 1) {
            menu.addClass('show');
            listItems.each(function() {
                var text = $(this).data('value');
                if ( text.toLowerCase().indexOf(query) > -1 ) {

                    var textStart = text.toLowerCase().indexOf( query );
                    var textEnd = textStart + query.length;
                    var htmlR = text.substring(0,textStart) + '<em>' + text.substring(textStart,textEnd) + '</em>' + text.substring(textEnd+length);
                    $(this).html( htmlR );
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            var count = listItems.filter(':visible').length;
            ( count > 0 ) ? hasNoResults.hide() : hasNoResults.show();

        } else {
            listItems.hide();
            dropdown.removeClass('open').removeClass('in');
            hasNoResults.show();
        }
    });

    listItems.on('click', function(e) {
        var txt = $(this).text().replace(/^\s+|\s+$/g, "");  //remove leading and trailing whitespace
        input.val( txt );
        menu.removeClass('show');
    });

}

$('.jAuto').each( createAuto );


$(document).on('focus', '.jAuto', function() {
    $(this).select();  // in case input text already exists
});

$(document).mouseup(function (e) {
    if ($(e.target).closest(".dropdown").length === 0) {
        $('.dropdown-menu').removeClass('show');
    }
});

