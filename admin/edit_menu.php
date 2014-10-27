<?
include_once 'includes/dblib.php';
include_once 'includes/lib.php';
confirmSession();

$headers_reg = getHeaders();
$headers = json_encode(getHeaders());
//var_dump($headers);

//GET DATA ARRAYS FOR PAGE
$menu_array = getMenuInfo($_GET['id']);
//var_dump($menu_array);
$menu_details = getMenuDetails($_GET['id']);
//var_dump($menu_details);

$count = count($menu_details);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sunflower Cafe Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="http://www.sunflowercafenashville.com">Sunflower Cafe</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="menu.php">Menus</a></li>
              <li><a href="#about">Activities</a></li>
				      <li><a href="#about">Updates</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
	  <div class="page-header">
  		<h1>Edit Menu <small>Welcome, <?= $_SESSION['name_first']; ?></small></h1>
	  </div>
    <span class="notice_here"></span>

		<form  name="login" action="includes/submit_menu.php" method="POST" >
      
      <div class="well"> 
        <p><?= date("l jS", strtotime($menu_array['day']));?> </b></p>     

  			<button class="btn" id="add_items" type="button" >add item</button>
        <div style="padding: 10px 0px;"></div>
<?

        $i = 1;
        $html = '';

        foreach ( $menu_details as $item ) {

          $html .= '<div><select name="headings[]" id="heading_'. $i .'">';

          foreach ( $headers_reg as $header) {

            $html .= '<option value="'. $header['id'] .'"';

            if ( $item['header_id'] == $header['id'] ) $html .= ' selected';

            $html .= '>'. $header['header'] .'</option>';

          }
                    
          $html .= '</select><input type="text" name="items[]" id="item_'. $i .'" value="'.$item['description'].'"/><a style="padding-left: 5px;" href="#" class="removeclass">&times;</a></div>';
          $i++;
        }
        echo $html;
?>
  			<div id="input_wrapper" style="padding: 10px 0px;"></div>
      </div>
      <input type="hidden" name="id" value="<?= $_GET['id']; ?>" />
			<button class="btn btn-large" type="submit">save menu</button>
		</form>
            
  </div> <!-- /container -->

	<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>

	
    <script type="text/javascript">
      $(document).ready(function() {

        $('.datepicker').datepicker();

        var currentCount = <?= $count; ?>;

        var InputsWrapper   = $("#input_wrapper"); //Input boxes wrapper ID
        var AddButton       = $("#add_items"); //Add button ID

        var headers         = <?= $headers; ?>;

        var FieldCount = currentCount + 1; //to keep track of text box added

        $(AddButton).click(function (e)  //on add input button click
        {
                //add input box
                var html = '<div><select name="headings[]" id="heading_'+ FieldCount +'">';

                jQuery.each(headers, function(id, header) {
                    html += '<option value="'+ header['id'] +'">'+ header['header'] +'</option>';
                });
                
                html    += '</select><input type="text" name="items[]" id="item_'+ FieldCount +'" placeholder="item '+ FieldCount +'"/><a style="padding-left: 5px;" href="#" class="removeclass">&times;</a></div>';
               
                $(InputsWrapper).append(html);
    		        FieldCount++; //text box added increment
                return false;
        });

        $("body").on("click",".removeclass", function(e) { //user click on remove text
            $(this).parent('div').remove(); //remove text box
            return false;
        });

        

      });
    </script>

    <script src="js/display_notice.js"></script>

    <script type="text/javascript">
      $(document).ready( function() {
        $.urlParam = function(name){
              var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
              return results[1] || 0;
        }

        if ($.urlParam('notice')) { 
          console.log($.urlParam('notice'));    
                display_notice($.urlParam('notice'), $.urlParam('notice_good_bad'));
        }
      });
    </script>

  </body>
</html>
