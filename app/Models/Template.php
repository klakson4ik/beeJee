<?php

namespace app\Models;

class Template
{

	public static function getHtml($tpl, $data = null)
   {

   	ob_start();
		require PAGES .  $tpl;
		$content = ob_get_clean();
		require VIEWS . "/Layouts/default.php";
      return ob_get_clean();
   }

}
