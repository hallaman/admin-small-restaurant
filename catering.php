<?php
include_once 'admin/includes/lib.php';

$startday = date('Y-m-d',time()+( 1 - date('w'))*24*3600);

$prettystartday = date("M jS", strtotime($startday));

$week_array = getWeeksMenu($startday);

//print_r($week_array);

?>

<!DOCTYPE html>
<html>

  <head>

     <meta http-equiv="content-type" content="text/html; charset=windows-1250">
<? include('includes/description.php') ?>
     <title>Catering</title>
     
      <link rel="shortcut icon" href="images/favicon.ico" />
      <link rel="stylesheet" type="text/css" href="css/main.css" />   
      <link rel="stylesheet" type="text/css" href="css/header.css" />
      <link rel="stylesheet" type="text/css" href="css/sub-menu.css" />

      <script type='text/javascript' src='js/main.js'></script>

      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
      
      <link rel="stylesheet" type="text/css" href="css/jquery-price-calculator-pro.css"/>
      <link rel="stylesheet" type="text/css" href="css/jquery-order-form.css"/>
      <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

     
   </head>
   
   <body>
   <?php include ('includes/analytics.php'); ?>
   <table align="center" width="700px">
   <tr><td><?php include ('includes/header.php'); ?></td></tr>
   <tr><td><?php include ('includes/sub-menu.php'); ?></td></tr>
   <tr>
   <td>
      <div class="content">
        <p style="padding: 15px; text-indent: 20px; color: #fff; background-image: url('../images/redtexturebg.jpg');">Sunflower Cafe offers exceptional vegan and vegetarian catering services at our beautiful restaurant 
          or for pickup to use at any location you choose.  We cater to most dietary needs including Gluten Free,
          Soy Free, and Dairy Free.  Our chefs have years of catering experience and can help you plan
          and execute your perfect event.  We welcome parties of all sizes, large or small, and also offer meals 
          to go.<br /><br />
          For more information contact us at 615-294-7205<br /> or <a style="color: #fff;" href="mailto:ordering@sunflowercafenashville.com">ordering@sunflowercafenashville.com</a>.
        </p>
        <div>
         <img src="documents/catering_menu.png" alt="Catering Menu" />
        </div>

        

      </div>
   </td>
   </tr>
   <tr><td><?php include ('includes/footer.php'); ?></td></tr>
   </table> 

   

  </body>

</html>