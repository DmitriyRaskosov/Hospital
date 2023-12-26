<?php
require_once '../models/Appointments.php';
class AppointmentsController {

    public function getOne ($id)
    {
        $model = new Appointments($_GET['name'], $_GET['date'], $_GET['doctor_type']);
        return $model->getOne($id);
    }

    public function getAll ()
    {
        $model = new Appointments();
        return $model->getAll();
    }

    public function create ()
    {
        $model = new Appointments($_POST['name'], $_POST['date'], $_POST['doctor_type']);
        return $model->create();
    }

    public function update ($id)
    {
        $model = new Appointments();
        return $model->update($id);
    }

    public function delete ($id, $model_name)
    {
        $model = new Appointments;
        return $model->delete($id);
    }
}