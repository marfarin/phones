$('.modalButton').click(function (){
    $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});

jQuery(document).ready(function() {
    jQuery('#example').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "person/ajax",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "last_name" },
            { "data": "first_name" },
            { "data": "second_name" },
            { "data": "phone_number" },
            { "data": "spec.spec_name" }
        ]
    } );
} );