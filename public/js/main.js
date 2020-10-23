
"use strict";

/***********************************************************
 *
 * 			SCRIPT DE TRAITEMENT PRINCIPAL
 *
 *			@By Jerome Dh
 *
 *			@date 15/10/2020
 *
 **********************************************************/

// Evenments
$(function () {

    // Language changing
    $('[name="change_language"]').on('change', function (e) {
        let me = ($(this))[0],
            lang = me.options[me.selectedIndex].value,
            uri = '/settings/' + lang + '?url=' + location.href;
        location.href = '/settings/' + lang + '?url=' + location.href;
    });

});
