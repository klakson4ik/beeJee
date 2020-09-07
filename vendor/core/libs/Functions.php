<?php

   function debug($arr)
   {
      echo '<pre>' . print_r($arr, true) . '</pre>';
   }


   function redirect($http = false)
   {
      if($http)
         $redirect = $http;
      else
         $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
      header("Location: $redirect");
      exit;
   }

   function checkTime($script){
       $startTime = new DateTime('now');
       $script;
       $endTime = new DateTime('now');
       $interval = $startTime->diff($endTime);
       echo ($interval->format('%S секунд, %f  микросекунд'));
   }
