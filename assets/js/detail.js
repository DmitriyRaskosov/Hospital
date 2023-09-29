$(document).ready(function () {
    var app_id = location.pathname.split('/')[2];
    console.log(app_id);
    $.ajax({
        url: "api/spec_appointment.json?id="+app_id,
        context: document.body
    }).success(function(data) {
        console.log(data);
        render_appointment(data);
    });

    function render_appointment(app) {
        var big_tag = '<section class="6u 12u(narrower)">' +
            '<div class="box post">' +
            '<a href="detail.html?id='+app.id+'" class="image left"><img src="images/pic01.jpg" alt="" /></a>' +
            '<div class="inner">' +
            '<h2>Пациент: '+app.patient_name+'</h2>' +
            '<h3>Врач: '+app.doctor_type+'</h3>' +
            '<p>Запись на '+app.appointment_date+'</p>' +
            '<button class="button update_appointment">Перенести запись</button>' +
            '<button class="button delete_appointment">Отменить запись</button>' +
            '</div>' +
            '</div>' +
            '</section>'
        $('div#appointment_detail').html(big_tag);
        $('.delete_appointment').click(function(){
            $.ajax({
                url: "api/update_appointment.php?id="+app_id,
                context: document.body
            }).success(function(data) {
                console.log(data);
                render_appointment(data);
            });
        });
        $('.delete_appointment').click(function(){
            $.ajax({
                url: "api/delete_appointment.php?id="+app_id,
                context: document.body
            }).success(function(data) {
                console.log(data);
                location.replace("index.html");
            });
        });
    }
});