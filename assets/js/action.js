$(document).ready(function () {
    console.log('alive!');
    $.ajax({
        url: "api/appointments.php",
        context: document.body
    }).done(function(data) {
        console.log(data);
        data.forEach(render_appointments);
    });

    function render_appointments(app) {
        var short_tag = '<li><a href="detail.html?id='+app.id+'">'+app.doctor_type+' '+app.appointment_date+'</a></li>';
        $('ul#appointments_short').append(short_tag);

        var big_tag = '<section class="6u 12u(narrower)">' +
            '<div class="box post">' +
            '<a href="detail.html?id='+app.id+'" class="image left"><img src="images/pic01.jpg" alt="" /></a>' +
            '<div class="inner">' +
            '<h3>'+app.doctor_type+'</h3>' +
            '<p>Запись на '+app.appointment_date+'</p>' +
            '</div>' +
            '</div>' +
            '</section>'
        $('div#appointments_big').append(big_tag);
    }
});