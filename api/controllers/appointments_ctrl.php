<?php

if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}

if (!isset($_POST['name']) || strlen($_POST['name']) <= 0) {
	throw new exception('Имя не указано');
}
if (!isset($_POST['date']) || strlen($_POST['date']) <= 0) {
	throw new exception('Дата записи не указана');
}
if (!isset($_POST['doctor_type']) || strlen($_POST['doctor_type']) <= 0) {
	throw new exception('Врач не указан');
}

if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}
if (!isset($_POST['date'])) {
	throw new exception('хуй, а не дата');
}

if (!isset($_GET['id']) || !(int)$_GET['id']) {
	throw new exception('ID не указан, не является числовым значением или равен нулю');
}
