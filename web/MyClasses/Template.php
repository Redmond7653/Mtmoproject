<?php
  
  namespace MyClasses;
  class Template
  {
    private $template;
    
    public function include($html_template, $render = []) {
      // $user_array_messages = null, $page_number = null, $user_name = null
      echo "<!--Begin_output.$html_template-->";
      include $html_template;
      echo "<!--End_output.$html_template-->";
    }
    
    public function first_line($template) {
      $fp = fopen($template,'w');
      fwrite($fp, 'begin_output');
      fclose($fp);
    }
  }