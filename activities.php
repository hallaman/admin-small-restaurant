<?php

include_once 'admin/includes/lib.php';

$activities = getActivities();
   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

  <head>

     <meta http-equiv="content-type" content="text/html; charset=windows-1250">
<? include('includes/description.php') ?>
     <title>Events</title>
     
      <link rel="shortcut icon" href="images/favicon.ico" />
      <link rel="stylesheet" type="text/css" href="css/main.css" />   
      <link rel="stylesheet" type="text/css" href="css/header.css" />
      <link rel="stylesheet" type="text/css" href="css/sub-menu.css" />

      <script type='text/javascript' src='js/main.js'></script>
      
     
   </head>
   
   <body>
   <table align="center" width="700px">
   <tr>
   <td>
      <div class="content">
         <!--<p style="text-align: left;">There are no scheduled activities.  Please check back.</p>-->
<?
         if (date('Y-m-d') >= $activities['end_date']) {
            echo '<p>Please check back soon to see our upcoming events.</p>';

         } else {
?>
         <div style="text-align: center;">
            <?= stripslashes($activities['activity_text']);?>
         </div>
<? 
         }
?>


      </div>
   </td>
   </tr>
   </table>

   </body>

</html>