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
     <title>To Go Orders</title>
     
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
        <div>
          <h4>Click to see our specials for the week of <?= $prettystartday; ?>:</h4>
          <ul class="showMenu well">
            <li><a href="">Monday</a></li>
            <li><a href="">Tuesday</a></li>
            <li><a href="">Wednesday</a></li>
            <li><a href="">Thursday</a></li>
            <li><a href="">Friday</a></li>
            <li><a href="">Saturday</a></li>
          </ul>
<? 
          foreach($week_array as $day) {

            $dayid = date('l', strtotime($day['day']));
            $sorted_items = '';

            if (empty($day['items'])) {

              $sorted_items .= '<p> No items posted for this day. </p>';

            } else {

              foreach($day['items'] as $item) {

                  if ( $item['header_id'] == '1') {

                    $sorted_items .= '<p> <b>Daily Chef Special</b> <span style="display: block; padding-left: 5px;">'. stripslashes($item['description']) .'</span></p>';

                  }

                  if ( $item['header_id'] == '4') {

                    $sorted_items .= '<p> <b>Bean of the day</b> <span style="display: block; padding-left: 5px;">'. stripslashes($item['description']) .'</span></p>';

                  }

                  if ( $item['header_id'] == '5') {

                    $sorted_items .= '<p> <b>Vegetable of the day</b> <span style="display: block; padding-left: 5px;">'. stripslashes($item['description']) .'</span></p>';

                  }
       
              }

            }

            
            echo '
                  <div id="'. $dayid .'" class="well">
                  <h3>'. $dayid .'</h3>
                  '. $sorted_items .'
                  </div>
                 ';
          }
?>

        </div>
        <div style="clear: both;"></div>
        <form id="jquery-order-form" class="jof form-horizontal" action="includes/payments.php" method="post" enctype="multipart/form-data">
        
        <h3>1. Enter Your Information</h3>

        <div class="option">
            <div class="well well_color_1">

              <p><strong>Your Email </strong></p>
              <p><input type="text" id="email" name="email" value=""/></p>

              <p><strong>Choose Date</strong></p>
              <input type="text" class="input-append date datepicker" id="date" name="date" />
            </div>
          </div>

          <h3>2. Choose Your Boxed Lunch</h3>
          <div class="option">
            <div class="well well_color_2">

              <h4 id="add_cs">Chef Special with 2 Sides - $11.00</h4>
              <p>See daily menu above for details.</p>
            <button class="btn add" id="chefspecial" type="button" ><b>Add to order</b></button>

            </div>
          </div>

          <div class="option">
            <div class="well well_color_2">

              <h4>Sandwich with 2 Sides - $11.00</h4>

            <button class="btn add" id="sandwich" type="button" ><b>Add to order</b></button>

            </div>
          </div>

          <div class="option">
            <div class="well well_color_2">

              <h4>Choose 3 Sides - $9.00</h4>

            <button class="btn add" id="three" type="button" ><b>Add to order</b></button>

            </div>
          </div>

<!--          <div class="option">
            <div class="well well_color_2">

              <h4>Desserts</h4>

             <button class="btn add" id="dessert" type="button" ><b>Add to order</b></button>

            </div>
          </div> -->

          <h3 id="step_3" style="display: none;">3. Refine Your Order</h3>
          <div id="items"></div>

          <input name="cmd" type="hidden" value="_xclick" />

          <input name="no_note" type="hidden" value="1" />

          <input name="lc" type="hidden" value="EN" />

          <input name="currency_code" type="hidden" value="USD" />

          <input name="bn" type="hidden" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

          <input name="first_name" type="hidden" value="" />

          <input name="last_name" type="hidden" value="" />

          <input name="payer_email" id="payer_email" type="hidden" value="customer@example.com" />

          <input name="item_number" id="item_number" type="hidden" value="123456" />    

          <p><input class="submit btn btn-primary btn-large" type="submit" value="Place Your Order"></p>

        </form>


      </div>
   </td>
   </tr>
   <tr><td><?php include ('includes/footer.php'); ?></td></tr>
   </table> 

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-price-calculator-pro.js"></script>

     <script type="text/javascript">
     $(document).ready(function() {

        $('#Monday').show();


        

        var form = $('#jquery-order-form');

        form.jPrice({
          "floatSub": true,
          "showPricesOption": false,
          "itemize": true,
          "showZeroAs": "",
          "subAlign": "right",
          "decimalSep": ".",
          "pricesFadeTime": "",
          "emptySummaryText": "<p>Your order is empty.<\/p>",
          "showPrices": false,
          "signBefore": "$",
          "signAfter": "",
          "items": {
              "cs_s_1_1": "First side",
              "cs_s_2_2": "Second side",
              "cs_q_1": "Chef Special"
          }
      });

      /* disable form submission */
      form.on('submit', function(event){
        event.preventDefault();
        
        // validate email
        var regex  = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email = $("#email").attr("value");

        if(!regex.test(email)){
          alert("Please enter a valid e-mail address");
          // var modal = $('<div class="modal hide fade" id="add-options-modal"><div class="modal-header"><a class="close" data-dismiss="modal">&times;</a>            <h2>Oops! Form Submission Disabled</h2></div><div class="modal-body"><p></p></div><div class="modal-footer">            <a href="#" data-dismiss="modal" class="btn btn-primary add">Okay</a></div></div>');
          // modal.appendTo("body");
          // modal.modal();
          return false;
        }

        var date = $("#date").attr("value");

        if (date == '') {
          alert("Please choose a date");
          return false;
        }

        var total = $('#total-cost').val();
        var order = $('.itemized-summary').html();

        if (total != 0) {

          $.post("includes/save_order.php", { total: total, order: order, date: date, email: email })
          .done(function(data) {

            var p_email = $('#email').val();

            $('#item_number').val(data);
            $('#payer_email').val(p_email);

            form.unbind("submit");

            form.submit();

          });


        } else {
          alert("Your order is empty");
          return false;
        }
        
      });


      $('.datepicker').datepicker({
          minDate: 1,
          beforeShowDay: function(date){ 
            return [date.getDay() != 0,""]
          },
          dateFormat: 'yy-mm-dd' 
      });

      var AddButton       = $(".add"); //Add button ID

      $(AddButton).click(function (e) {

        var type = $(this).attr('id');

        addtoMenu(type);
       
      });

      function addtoMenu(type) {

          var csitems  = $('.chefspecial').length;
          var sitems   = $('.sandwich').length;
          var titems   = $('.three').length;
          // var ditems   = $('.dessert').length;

          var numItems = csitems +
                         sitems  +
                         titems; 
                         // +
                         // ditems;
          
          var html = '';
          var items = {}

          var chefSpecial    = '<option value="Daily Chef Special" data-cost="0" >Daily Chef Special - see daily menu above</option><option value="Ginger Thai Tofu" data-cost="0" >Ginger Thai Tofu</option>';
          var sideOptions    = '<option value="Vegetable of the day" data-cost="11" >Vegetable of the day - see daily menu above</option><option value="Bean of the day" data-cost="11" >Bean of the day - see daily menu above</option><option value="Sweet Potatoes" data-cost="11" >Sweet Potatoes</option><option value="Fruit Crumble" data-cost="11" >Fruit Crumble</option><option value="Cold Kale Salad" data-cost="11" >Cold Kale Salad</option><option value="Fruit" data-cost="11" >Fruit</option><option value="Potato Salad" data-cost="11" >Potato Salad</option>';
          var secsideOptions = '<option value="Quinoa" data-cost="0" >Quinoa</option><option value="Sunflower Rice" data-cost="0" >Sunflower Rice</option><option value="Mixed Greens with Homemade Balsamic Dressing" data-cost="0" >Mixed Greens with Homemade Balsamic Dressing</option></select>';
          var sideOptions9   = '<option value="Vegetable of the day" data-cost="9" >Vegetable of the day - see daily menu above</option><option value="Bean of the day" data-cost="9" >Bean of the day - see daily menu above</option><option value="Sweet Potatoes" data-cost="9" >Sweet Potatoes</option><option value="Fruit Crumble" data-cost="9" >Fruit Crumble</option><option value="Cold Kale Salad" data-cost="9" >Cold Kale Salad</option><option value="Fruit" data-cost="9" >Fruit</option><option value="Potato Salad" data-cost="9" >Potato Salad</option>';
          var sideOptions0   = '<option value="Vegetable of the day" data-cost="0" >Vegetable of the day - see daily menu above</option><option value="Bean of the day" data-cost="0" >Bean of the day - see daily menu above</option><option value="Sweet Potatoes" data-cost="0" >Sweet Potatoes</option><option value="Fruit Crumble" data-cost="0" >Fruit Crumble</option><option value="Cold Kale Salad" data-cost="0" >Cold Kale Salad</option><option value="Fruit" data-cost="0" >Fruit</option><option value="Potato Salad" data-cost="0" >Potato Salad</option>';
          // var dessertOptions = '<div class="well"><h4>Add a Dessert</h4><label><strong>*Additional cost </strong><div class="sub-option o-radio" data-type="select"><div class="well"><p><ul><li><input type="radio"  data-cost="2.5" value="2 Rice Krispy Treats" name="d_s_1_'+ ditems +'"/><label for="d_s_1_'+ ditems +'">2 Rice Krispy Treats - $2.50</label></li><li><input type="radio" checked="checked" data-cost="3" value="Chocolate Mousse" name="d_s_1_'+ ditems +'"/><label for="d_s_1_'+ ditems +'">Chocolate Mousse - $3.00</label></li></ul></div></div>';

          if (type == 'chefspecial') {

            csitems = csitems+1;
            html = '<div class="option chefspecial"><div class="well"><h4>Chef Special with 2 Sides - $11.00</h4><label><strong>How Many? </strong><input type="number" min="0" name="cs_q_'+ csitems +'" id="cs_q_'+ csitems +'" value="1" data-quantity="cs_s_1_'+ csitems +',cs_s_2_'+ csitems +'[]"/></label><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose Chef Special </strong></p><p><select name="cs_type'+ csitems +'" id="cs_type'+ csitems +'" >'+ chefSpecial +'</select></p></div></div><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose First Side </strong></p><p><select name="cs_s_1_'+ csitems +'" id="cs_s_1_'+ csitems +'" >'+ sideOptions +'</select></p></div></div><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose Second Side </strong></p><p><select name="cs_s_2_'+ csitems +'" id="cs_s_2_'+ csitems +'" >' + secsideOptions + '</select></p></div></div><p><b>Name</b> (optional) <input type="text" id="cs_name_'+ csitems +'" name="cs_name_'+ csitems +'"/></p><h4>Add a Dessert</h4><label><div class="sub-option o-radio" data-type="select"><div class="well"><p><ul><li><input type="radio" value="" checked="checked" name="cs_d_'+ csitems +'"/><label for="cs_d_'+ csitems +'">No dessert</label></li><li><input type="radio"  data-cost="2.5" value="2 Rice Krispy Treats" name="cs_d_'+ csitems +'"/><label for="cs_d_'+ csitems +'">2 Rice Krispy Treats - $2.50</label></li><li><input type="radio" data-cost="3" value="Chocolate Mousse" name="cs_d_'+ csitems +'"/><label for="cs_d_'+ csitems +'">Chocolate Mousse - $3.00</label></li></ul></div></div><p><button class="add_cs" type="button" ><b>Choose Another Boxed Lunch</b></button></p></div></div>';

          } else if (type == 'sandwich') {
           
            sitems = sitems+1;
            html = '<div class="option sandwich"><div class="well"><h4>Sandwich with 2 Sides - $11.00</h4><label><strong>How Many? </strong><input type="number" min="0" name="s_q_'+ sitems +'" id="s_q_'+ sitems +'" value="1" data-quantity="s_s_1_'+ sitems +',s_s_2_'+ sitems +'[]"/></label><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose First Side </strong></p><p><select name="s_s_1_'+ sitems +'" id="s_s_1_'+ sitems +'" >'+ sideOptions +'</select></p></div></div><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose Second Side </strong></p><p><select name="s_s_2_'+ sitems +'" id="s_s_2_'+ sitems +'" >' + secsideOptions + '</select></p></div></div><p><b>Name</b> (optional) <input type="text" id="s_name_'+ sitems +'" name="s_name_'+ sitems +'"/></p><h4>Add a Dessert</h4><label><div class="sub-option o-radio" data-type="select"><div class="well"><p><ul><li><input type="radio" value="" checked="checked" name="s_d_'+ sitems +'"/><label for="s_d_'+ sitems +'">No dessert</label></li><li><input type="radio"  data-cost="2.5" value="2 Rice Krispy Treats" name="s_d_'+ sitems +'"/><label for="s_d_'+ sitems +'">2 Rice Krispy Treats - $2.50</label></li><li><input type="radio" data-cost="3" value="Chocolate Mousse" name="s_d_'+ sitems +'"/><label for="s_d_'+ sitems +'">Chocolate Mousse - $3.00</label></li></ul></div></div><p><button class="add_cs" type="button" ><b>Choose Another Boxed Lunch</b></button></p></div></div>';

          } else if (type == 'three') {

            titems = titems+1;
            html = '<div class="option three"><div class="well"><h4>Choose 3 Sides - $9.00</h4><label><strong>How Many? </strong><input type="number" min="0" name="t_q_'+ titems +'" id="t_q_'+ titems +'" value="1" data-quantity="t_s_1_'+ titems +',t_s_2_'+ titems +'[],t_s_3_'+ titems +'[]"/></label><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose First Side </strong></p><p><select name="t_s_1_'+ titems +'" id="t_s_1_'+ titems +'" >' + sideOptions9 + '</select></p></div></div><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose Second Side </strong></p><p><select name="t_s_2_'+ titems +'" id="t_s_2_'+ titems +'" >' + sideOptions0 + '</select></p></div></div><div class="sub-option o-select" data-type="select"><div class="well"><p><strong>Choose Third Side </strong></p><p><select name="t_s_3_'+ titems +'" id="t_s_3_'+ titems +'" >' + secsideOptions + '</select></p></div></div><p><b>Name</b> (optional) <input type="text" id="t_name_'+ titems +'" name="t_name_'+ titems +'"/></p><h4>Add a Dessert</h4><label><div class="sub-option o-radio" data-type="select"><div class="well"><p><ul><li><input type="radio" value="" checked="checked" name="t_d_'+ titems +'"/><label for="t_d_'+ titems +'">No dessert</label></li><li><input type="radio"  data-cost="2.5" value="2 Rice Krispy Treats" name="t_d_'+ titems +'"/><label for="t_d_'+ titems +'">2 Rice Krispy Treats - $2.50</label></li><li><input type="radio" data-cost="3" value="Chocolate Mousse" name="t_d_'+ titems +'"/><label for="t_d_'+ titems +'">Chocolate Mousse - $3.00</label></li></ul></div></div><p><button class="add_cs" type="button" ><b>Choose Another Boxed Lunch</b></button></p></div></div>';

          } 
          //else if (type == 'dessert') {

          //   ditems = ditems+1;
          //   html = '<div class="option dessert"><div class="well"><h4>Desserts</h4><label><strong>How Many? </strong><input type="number" min="0" name="d_q_'+ ditems +'" id="d_q_'+ ditems +'" value="1" data-quantity="d_s_1_'+ ditems +'"/></label><div class="sub-option o-radio" data-type="select"><div class="well"><p><ul><li><input type="radio"  data-cost="2.5" value="2 Rice Krispy Treats" name="d_s_1_'+ ditems +'"/><label for="d_s_1_'+ ditems +'">2 Rice Krispy Treats - $2.50</label></li><li><input type="radio" checked="checked" data-cost="3" value="Chocolate Mousse" name="d_s_1_'+ ditems +'"/><label for="d_s_1_'+ ditems +'">Chocolate Mousse - $3.00</label></li></ul></div><p><button class="add_cs" type="button" ><b>Choose Another Boxed Lunch</b></button></p></div>';

          // } 
          // console.log('cs: ' + csitems);
          // console.log('s: ' + sitems);
          // console.log('t: ' + titems);



          for (var k = 1; k <= csitems; k++) {
              // Build items dynamically

              var type  = "cs_type" + k;

              var sideOne  = "cs_s_1_" + k;
              var sideTwo  = "cs_s_2_" + k;
              var quantity = "cs_q_" + k;
              var name     = "cs_name_" + k;
              var dessert  = "cs_d_" + k;

              items[type]   = "Type";

              items[sideOne]   = "First side";
              items[sideTwo]   = "Second side";
              items[quantity]  = "Chef Special";
              items[dessert]   = "Dessert";

              items[name]      = "Name";
          }

          for (var i = 1; i <= sitems; i++) {
              // Build items dynamically
              var sideOne  = "s_s_1_" + i;
              var sideTwo  = "s_s_2_" + i;
              var quantity = "s_q_" + i;
              var name     = "s_name_" + i;
              var dessert  = "s_d_" + i;


              items[sideOne]   = "First side";
              items[sideTwo]   = "Second side";
              items[quantity]  = "Sandwich with 2 Sides";
              items[dessert]   = "Dessert";
              
              items[name]      = "Name";
             
          }

          for (var j = 1; j <= titems; j++) {
              // Build items dynamically
              var sideOne  = "t_s_1_" + j;
              var sideTwo  = "t_s_2_" + j;
              var sideThree= "t_s_3_" + j;

              var quantity = "t_q_" + j;
              var name     = "t_name_" + j;
              var dessert  = "t_d_" + j;

              items[sideOne]   = "First side";
              items[sideTwo]   = "Second side";
              items[sideThree] = "Third side";

              items[quantity]  = "Choose 3 Sides";
              items[dessert]   = "Dessert";
             
              items[name]      = "Name";
              items[dessert]   = "Dessert";
             
          }

          $('#items').prepend(html);
          $('#step_3').show();
          scrollTo('step_3');

          $('.add_cs, .add_s, .add_t, .add_d').click( function(e) {
            
            e.preventDefault();
            var thisclass = $(this).attr('class');
            console.log(thisclass);
            $('html, body').animate({scrollTop: $("#" + thisclass).offset().top },'slow');

          });

          

          //console.log(items);

          form.reRender({
              "floatSub": true,
              "showPricesOption": false,
              "itemize": true,
              "showZeroAs": "",
              "subAlign": "right",
              "decimalSep": ".",
              "pricesFadeTime": "",
              "emptySummaryText": "<p>Your order is empty.<\/p>",
              "showPrices": false,
              "signBefore": "$",
              "signAfter": "",
              "items": items             
          });
            
        return false;
      }

      function scrollTo(id) {
        // Scroll
        $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
      }

      $('.showMenu li a').click( function(e) {

        e.preventDefault();
        var day = $(this).html();

        $('#Monday').hide();
        $('#Tuesday').hide();
        $('#Wednesday').hide();
        $('#Thursday').hide();
        $('#Friday').hide();
        $('#Saturday').hide();

        $('#' + day).show();
      });

    });
    </script>


  </body>

</html>