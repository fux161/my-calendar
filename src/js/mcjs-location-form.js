(function ($) {
    $(function () {
        var existing_places = [];

        $.get( '/', {'show': 'locations', 'mc-api': 'json'}, function (response) {
            existing_places = response;

            $ ( '#select-1 select' ).change();
        }, "json" );

        /**
         * Display details when location was selected
         */
        $( '#select-1 select' ).on( 'change', function() {
            let selected = $( '#select-1 select' ).val();

            for (place of existing_places) {
                if (place['location_id'] == selected) {
                    $( "[name='name-1']").val(place['location_label']);
                    $( "[name='address-1-street_address']").val(place['location_street']);
                    $( "[name='address-1-city']").val(place['location_city']);
                    $( "[name='address-1-zip']").val(place['location_postcode']);
                    $( "[name='url-1']").val(place['location_url']);
                    return;
                } 
            }

            /* not found, empty all */
            $( "[name='name-1']").val('');
            $( "[name='address-1-street_address']").val('');
            $( "[name='address-1-city']").val('');
            $( "[name='address-1-zip']").val('');
            $( "[name='url-1']").val('');
        });
    });
}(jQuery));