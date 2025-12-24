$(document).ready(function () {
    console.log('Search autocomplete script loaded');
    if ($('#url_category').length) {
        console.log('Initializing autocomplete for URL category');
        $('#url_category').autocomplete({
            source: function (request, response) {
                console.log('Fetching category data for:', request.term);
                $.ajax({
                    url: ONLYBIO_AJAX_URL,
                    dataType: 'json',
                    data: {
                        q: request.term
                    },
                    success: function (data) {
                        // This part is crucial! It maps 'id' and 'name' from your PHP to 'value' and 'label'
                        response($.map(data, function (item) {
                            return {
                                label: item.name, // The text that appears in the dropdown
                                value: item.id,   // The ID that gets stored
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {

                $('#url_category_id').val(ui.item.value);
                $(this).val(ui.item.label);
                return false;
            }
        });
    }
});