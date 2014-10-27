<?php

function get_base_url(&$filename)
{
  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
  $path = $_SERVER['PHP_SELF'];
  $path_parts = pathinfo($path);
  $filename = $path_parts['filename'];
  $directory = $path_parts['dirname'];
  $directory = ($directory == "/") ? "" : $directory;
  $host = $_SERVER['HTTP_HOST'];
  return $protocol . $host . $directory;
}

   $filename = '';
   $baseUrl = get_base_url($filename).'/';

   if ($filename == 'complete-menu') {
    $filename = 'menu';
   }
   
   $subMenu = array(
      "home" => array('title' => 'Home', 'file' => ''),
      "location" => array('title' => 'Location', 'file' => 'location.php'),

      "menu" => array('title' => 'Menu', 'file' => 'menu.php'),
      "feedback" => array('title' => 'Feedback', 'file' => 'feedback.php'),
      "activities" => array('title' => 'Events', 'file' => 'activities.php'),


      "about-us" => array('title' => 'About Us', 'file' => 'about-us.php'),

      "catering" => array('title' => 'Catering', 'file' => 'catering.php'),

      "contact-us" => array('title' => 'Contact', 'file' => 'contact-us.php')
      );   
   
?>

   <div id='cssmenu'>
      <ul> <?php
         foreach ($subMenu as $mKey => $mItem)
         { 
         $class = ($mKey != $filename) ? '' : "active";
         $class2 = ($mKey == 'contact-us') ? 'last' : "";
        // $anchorStart = ($mKey != $filename) ? "<a href='$baseUrl".$mItem['file']."'>" : ''; 
        // $anchorStop = ($mKey != $filename) ? "</a>" : ''; 
           $anchorStart = "<a href='$baseUrl".$mItem['file']."'>"; 
           $anchorStop = "</a>"; 
         ?>
         <li class="<?php echo $class.' '.$class2; ?>"><?php echo $anchorStart; ?><span><?php echo $mItem['title']; ?></span><?php echo $anchorStop; ?></li> <?php
         } ?>
      </ul>
   </div>