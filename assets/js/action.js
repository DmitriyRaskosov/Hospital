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
        let short_tag = '<li><a href="detail.html?id='+app.id+'">'+app.doctor_type+' '+app.appointment_date+'</a></li>';
        $('ul#appointments_short').append(short_tag);

        let big_tag = '<section class="6u 12u(narrower)">' +
            '<div class="box post">' +
            '<a href="detail.html?id='+app.id+'" class="image left"><img src="images/pic01.jpg" alt="" /></a>' +
            '<div class="inner">' +
            '<h3>'+app.doctor_type+'</h3>' +
            '<p>Запись на '+app.date+'</p>' +
            '</div>' +
            '</div>' +
            '</section>'
        $('div#appointments_big').append(big_tag);
    }

    $('.create_appointment').click(function(event){
        event.preventDefault();
        var patient_name = document.getElementById('patient_name').value;
        let appointment_date = document.getElementById('appointment_date').value;
        let doctor_type = document.getElementById('doctor_type').value;
        let body = {'name': patient_name, "date": appointment_date, "doctor_type": doctor_type};
        console.log(body);
        $.ajax({
            method: "POST",
            url: "api/create_appointment.php",
            data: body,
        }).always(function() {
            alert('Новый талон добавлен!');
            setTimeout(function(){
                location.reload();
            }, 3000);
        })
    });
});