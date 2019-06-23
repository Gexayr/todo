$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function changeStatus(id, element){
    var status = $(element).parent().find('select').val();
    var formData = new FormData();
    formData.append('status', status);
    formData.append('id', id);
    $.ajax({
        url: '/change-status',
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $(element).text('wait');
        },
        success: function (result) {
            console.log(result);
            $(element).text('Save');
            if(result != 1){
                alert('error')
            }
        }
    });
}

