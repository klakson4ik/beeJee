<?php

namespace vendor\core\libs;


class Cache
{
   public static function setCache($key, $data, $seconds = 3600)
   {
      if($seconds)
         {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content)))
               return true;
         }
      return false;
   }

   public static function getCache($key)
   {
      $file = CACHE . '/' . md5($key) . '.txt';
      if(file_exists($file))
      {
         $content = unserialize(file_get_contents($file));
         if(time() <= $content['end_time'])
            return $content['data'];
         unlink($file);
      }
      return false;

   }

   public static function deleteCache($key)
   {
      $file = CACHE . '/' . md5($key) . '.txt';
      if(file_exists($key))
         unlink($file);
   }
}


 ?>
