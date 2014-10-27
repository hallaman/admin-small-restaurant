<?
include_once 'includes/dblib.php';
include_once 'includes/lib.php';
confirmSession();

$headers = json_encode(getHeaders());
//var_dump($headers);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
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
          <a class="brand" href="">Admin</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="menu.php">Menus</a></li>
              <li><a href="activities.php">Events</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
	  <div class="page-header">
  		<h1>Menus  <small>Welcome, <?= $_SESSION['name_first']; ?></small></h1>
	  </div>
    <span class="notice_here"></span>

		<form  name="login" action="includes/submit_menu.php" method="POST" >
      
      <div class="well">      
        <div class="input-append date datepicker" data-date="2012-12-12" data-date-format="yyyy-mm-dd">
          <label for="date">Choose Menu Date</label>
          <input class="span2" name="date" size="16" type="text" value="2012-12-12">
          <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
      </div>
      <div class="well"> 
        <input type="hidden" name="meal" value="lunch" />
        <!-- <select name="meal" style="margin-bottom: 0px;">
          <option value="lunch">Lunch</option>
          <option value="dinner">Dinner</option>
        </select> -->
  			<button class="btn" id="add_items" type="button">add item</button>
  			<div id="input_wrapper" style="padding: 10px 0px;"></div>
      </div>
			<button class="btn btn-large" type="submit">submit menu</button>
		</form>
		

    <hr />
		<h3>menus </h3>
    <div class="dropdown clearfix">
      <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display: block; position: static; margin-bottom: 5px; *width: 180px;">
<?


    $sql =<<<SQL

    SELECT   id,
             day,
             meal,
             max(date_submitted) as ds
    FROM     menus
    WHERE    day >= :now

    GROUP BY day,
             meal
    ORDER BY day DESC
    LIMIT    28

SQL;

  $stmt = $db->prepare($sql);

  $now = date ('Y-m-d');

  $stmt->execute(array('now' => $now));

  foreach ($stmt as $row) {
    echo '<li><a tabindex="-1" href="edit_menu.php?id='.$row['id'].'">'.date("l, M jS", strtotime($row['day'])).'</a></li>';

  }

  

?>
      </ul>
    </div>
            
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

        $('.datepicker').datepicker('setValue', new Date());

        var MaxInputs       = 20; //maximum input boxes allowed
        var InputsWrapper   = $("#input_wrapper"); //Input boxes wrapper ID
        var AddButton       = $("#add_items"); //Add button ID

        var headers         = <?= $headers; ?>;

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount = 1; //to keep track of text box added

        $(AddButton).click(function (e)  //on add input button click
        {
                if(x <= MaxInputs) //max input box allowed
                {
                    //add input box
                    var html = '<div><select name="headings[]" id="heading_'+ FieldCount +'">';

                    jQuery.each(headers, function(id, header) {
                        html += '<option value="'+ header['id'] +'">'+ header['header'] +'</option>';
                    });
                    
                    html    += '</select><input type="text" name="items[]" id="item_'+ FieldCount +'" placeholder="item '+ FieldCount +'"/><a style="padding-left: 5px;" href="#" class="removeclass">&times;</a></div>';
                   
                    $(InputsWrapper).append(html);
                    x++; //text box increment
        		        FieldCount++; //text box added increment
                }
                return false;
        });

        $("body").on("click",".removeclass", function(e) { //user click on remove text
            if( x > 1 ) {
                    $(this).parent('div').remove(); //remove text box
                    x--; //decrement textbox
            }
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
