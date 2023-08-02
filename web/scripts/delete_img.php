<?php

use MyClasses\Db;
use MyClasses\Template;

$db = new Db();

$delete = $db->query("DELETE FROM `images` WHERE `id` = '{$_REQUEST['image_id']}'");

//_template('change_message');


