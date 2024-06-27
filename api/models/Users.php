<?php

require_once 'AbstractModel.php';

class Users extends AbstractModel {

	public static $table_name = 'Users';

	public static $attributes = ['email', 'password', 'role_mask', 'key', 'key_timestamp'];

}