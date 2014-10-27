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
   <?php include ('includes/analytics.php'); ?>
   <table align="center" width="700px">
   <tr><td><?php include ('includes/header.php'); ?></td></tr>
   <tr><td><?php include ('includes/sub-menu.php'); ?></td></tr>
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

         <!--
         <p style="text-align: left;"><strong>Sunflower Cafe</strong> is interesting in hosting activities consistent with our mission and developing community.  Please <a href="contact-us.php" target="_self">contact us</a> if you have an event you'd like us to host at Sunflower Cafe.</p>
         -->
         
         <!--
         <a name="compassionate-nashville"></a><p style="text-align: center; padding: 12px; border: 1px solid #84B477; background-color: #DCD0E5;"><strong>Coming this Thursday Evening the 24th of January from 6 to 9 pm</strong>:<br><i>Join Compassionate Nashville for a Compassionate Coffeehouse</i></p>
         <ul>
         <li>Food and drinks will be available for purchase.</li>
         <li>Sign-up for a performance spot at 6:30pm.</li>
         <li>The performances will commence at 7pm.</li>
         <li>Click <a href="images/compassionate-nashville.pdf" target="_blank">here</a> for more information.</li>
         </ul>
         -->
         
         <!--
         <a name="-harper-vegetarian-cooking"></a><p style="text-align: center; padding: 12px; border: 1px solid #84B477; background-color: #DCD0E5;">&mdash; <strong>Coming next Sunday, March 17th from 3:00pm to 6:00pm</strong> &mdash;<br><i>Vegetables and More</i><br><strong>A Cooking Class Presented by Virginia Harper</strong></p>
         -->
         
         <!--         
         <p style="font-weight: bold; text-align: center;">Please check back for our next scheduled class coming soon!</p>
         -->
         
         <!--
         <p>Vegetables are the nutritious life source to our well being. They are full of enzymes, vitamins, minerals and water.  You will learn the value of seasonal selection and precise preparation for effective absorption of these nutirents.</p>
         
         <p style='text-align: center; color: #4E893D; font-weight: bold;'>You will learn how to cook garlic green beans with clinatro, Japanese root veggies with tahini sauce, kale rolls with mustard dressing, and pressed salad with toasted walnuts and apple.</p>
         -->

         <!--         
         <p>Come learn the importance of why balance components such as food combining and food preparation are key to supporting vital health.</p>
         -->
         
         <!--         
         <p style='text-align: center; color: #4E893D; font-size: 90%; font-weight: bold;'><i>Virginia Harper is a recognized authority on the application of natural whole foods as a means to improve diet and lifestyle.  To learn more about her remarkable story click <a href='/documents/virginia-harper-background.pdf' target='_blank'>here</a></i>.</p>
         
         <p>Reservations and attendance options are as follows:</p>
         <ul>
         -->
         
         <!--
         <li>This class is a repeat of the same class held earlier on January 16th and is back by popular demand.</li>
         -->
         
         <!--
         <li> $67 for first time participants; or</li>
         <li> $62 for repeat attendees; or</li>
         <li>$114 for a first time participant with spouse; or</li>
         <li>$104 for a repeat attendee with spouse.</li>
         </ul>
         -->

<!--
         <p>Due to limited availability reservations must be paid for in advance. Space is limited so <b>make your reservations online now!</b></p>
         
         <p> You may make your online payment and reservation using our PayPal site. Simply select an attendance option below and click on the PayPal Add to Cart button below.</p>

<center>
<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="UT7WQU7L85LCJ">
<table>

<tr>
   <td align="center">
      <input type="hidden" name="on0" value="Attendance Options">Attendance Options
   </td>
</tr>

<tr><td><select name="os0">
	<option value="First Time Participant">First Time Participant $67.00 USD</option>
	<option value="First Time Participant w/Spouse">First Time Participant w/Spouse $114.00 USD</option>
	<option value="Repeat Attendee">Repeat Attendee $62.00 USD</option>
	<option value="Repeat Attendee w/Spouse">Repeat Attendee w/Spouse $104.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</center>

-->

      <!--
      <p><center>
      -->

      <!--
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9DNM7GWJMK95C">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
      -->

      <!--
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="94WCYM38W934S">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
      </form>


      </center></p>
      -->

      </div>
   </td>
   </tr>
   <tr><td><?php include ('includes/footer.php'); ?></td></tr>
   </table> 

   </body>

</html>