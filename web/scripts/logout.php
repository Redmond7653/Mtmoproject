<?php

use MyClasses\Template;

unset($_SESSION['user']);
  $template = new Template();
  $template->include('template/auth.html');