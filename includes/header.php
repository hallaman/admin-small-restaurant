<?php
include_once 'admin/includes/lib.php';

$update = getUpdate();

?>

<table width="100%">
   <tr>
      <td width="270px">   
         <div id="logo" class="logo" onclick="page('');"></div>
      </td>
      <td>
         <div id="social" class="social";>
            <p><a title="Follow us on Facebook" href="http://www.facebook.com/sunflowercafenashville" target="_blank"><img src="images/facebook.png"></a></p>
            <p><a title="Follow us on Twitter" href="https://twitter.com/sunflowernash" target="_blank"><img src="images/twitter.png"></a></p>
         
            <p><a title="Follow us on Instagram" href="https://instagram.com/sunflowercafenashville" target="_blank"><img src="images/instagram_logo_small.png"></a></p>

         </div>
      </td>
      <td>
         <div id="intro" class="intro">

            <p style="float: left;">A Nashville Vegetarian Restaurant<br>Located in Berry Hill</p>
            <p style="float: right; padding-left: 10px; margin-top: 20px;"><a href="http://eatreal.org/locations/sunflower-cafe/" ><img src="images/real.png" alt="eatReal.org" style="background-color: white; padding: 5px;"/></a></p>

            <p><strong>Farm Fresh Locally Grown Produce</strong></p>

            <p>Featuring natural whole foods with a variety<br> of options including vegan, gluten free,<br> soy free, and dairy free selections.</p>
         </div>
      </td>
   </tr>
   

   <tr>
   <td colspan="3">
      <!--<div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #B0D3A7; color: #6B1088; font-weight: bold;">-->

	<div style="text-align: center; padding: 12px; border: 2px solid #6B1088; background-color: #DCD0E5;  color: #6B1088;">
<? 
			if (date('Y-m-d') >= $update['end_date']) {
 
				echo '<a href="activities.php" style="text-decoration: none; color: #6B1088;">Click Here to check out all our Exciting Events Coming Up at Sunflower Cafe!</span></a>';

			} else {

				echo '<a href="activities.php" style="text-decoration: none; color: #6B1088;">'. stripslashes($update['update_text']) .'</a>';


			}
?>
</div>

      <!--
      <div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #B0D3A7; color: #6B1088; font-weight: bold;"><span style=''>Join Compassionate Nashville</span> for a Compassionate Coffeehouse on Thursday, January 24th from 6 to 9 pm<br><span style="font-style: italic; font-size: 94%; font-weight: normal;">Food and drinks will be available for purchase. Performances will begin at 7pm.<br>Click <a href="http://www.sunflowercafenashville.com/activities.php#compassionate-nashville">here</a> to read more.</span></div>
      -->
      
      <!--
      <div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #B0D3A7; color: #6B1088; font-weight: bold;"><span style=''>Vegetarian Cooking with Chef Gabrielle</span><br>
      <span style="font-weight: bold; color: white; text-align: center;">This class is sold out!<br>Please check back for our next scheduled class coming soon!</span><span style="font-style: italic; font-size: 94%; font-weight: normal;"><br>Click <a href="http://www.sunflowercafenashville.com/activities.php#vegetarian-cooking">here</a> to read more.</span>
      -->

      <!--
      <div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #FEE13F; color: #6B1088; font-weight: bold;"><span style=''>&mdash; WE WILL BE CLOSED THIS MONDAY, MARCH 4TH FOR KITCHEN RENOVATIONS &mdash;<br>We will reopen with our normal hours on Tuesday, March 5th.<br><i>Thank You!</i></span><br>
      </div>
      -->

      <!--
      <div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #B0D3A7; color: #6B1088; font-weight: bold;"><span style=''>&ndash; Coming next Sunday, March 17th &ndash;<br>Vegetables and More:</span><br>
      A Cooking Class with Virginia Harper
      -->
      
      <!--
      <span style="font-weight: bold; color: white; text-align: center;">This class is sold out!<br>Please check back for our next scheduled class coming soon!</span>
      -->
      
      <!--
      <span style="font-style: italic; font-size: 94%; font-weight: normal;"><br>Click <a href="http://www.sunflowercafenashville.com/activities.php#harper-vegetarian-cooking">here</a> to read more.</span>
      -->
      
      <!-- <span style="font-style: italic; font-size: 94%; font-weight: normal;">Join Chef Gabrielle for a repeat of this class back by popular demand.<br>Click <a href="http://www.sunflowercafenashville.com/activities.php#vegetarian-cooking">here</a> to read more.</span>
      -->
      
      <!--
      </div>
      -->
      
      <!--
      <div style="text-align: center; border: 1px solid; padding: 6px; margin: 6px; background-color: #B0D3A7; color: #6B1088; font-weight: bold;"><span style=''>Our Gourmet Cooking Class with Chef Gabrielle on January the 16th is Sold Out!</span><br><span style="font-size: 94%; font-weight: normal;">We will soon be scheduling another class due to popular demand so please check our site often for future notifications.</span></div>
      -->
   
   </td>
   </tr>
   
</table>
 




                                                                                                                                                           