function getFinances (teamId, baseUrl) {

    $('#financesField').html('Calculando...');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var request = $.ajax({
        url: baseUrl + "/api/finances/team-finances",
        method: "GET",
        data: {
            teamId: teamId
        },
        dataType: "json"
    });

    request.done(function(data) {
        console.log(data);
        $('#financesField').html("R$ " + data.total);
    });
    
    request.fail(function(data) {
        console.log(data.statusText);
    });
}