<?
include_once 'includes/dblib.php';
include_once 'includes/lib.php';
confirmSession();

$activities = getActivities();


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
  		<h1>Activities  <small>Welcome, <?= $_SESSION['name_first']; ?></small></h1>
	  </div>
    <span class="notice_here"></span>

		<form  name="login" action="includes/submit_activity.php" method="POST" enctype="multipart/form-data">
       <div class="well">      
        <div class="input-append date datepicker" data-date="2012-12-12" data-date-format="yyyy-mm-dd">
          <label for="date">Show until</label>
          <input class="span2" name="date" size="16" type="text" value="2012-12-12">
          <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
      </div>
      <div class="well">      
        <!-- <div style="position:relative;">
          <a class='btn' href='javascript:;'>
              Choose Image...
              <input name="file" type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="40"  onchange='$("#upload-file-info").html($(this).val());'>
          </a>
          &nbsp;
          <span class='label label-info' id="upload-file-info"></span>
        </div> -->
        <div id="input_wrapper" style="padding: 10px 0px;"><textarea class="ckeditor" name="activity"></textarea></div>

      </div>
      
			<button class="btn btn-large" type="submit">submit activity</button>
		</form>
		<hr />
    <p><? echo '<b>Latest activity: </b>'. stripslashes($activities['file']) .' ends on ' . date("l, M jS", strtotime($activities['end_date'])); ?></p>

   
            
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
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

    <script src="js/display_notice.js"></script>

    <script>

      // Replace the <textarea id="editor"> with an CKEditor
      // instance, using default configurations.
      CKEDITOR.replace( 'activity', {
        // toolbar: [
        //   [ 'Bold', 'Italic', '-', 'FontSize', 'TextColor', 'BGColor' ]
        // ]
        filebrowserBrowseUrl : '/admin/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/admin/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/admin/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
      });

    </script>

    <script type="text/javascript">
      $(document).ready(function() {

        $('.datepicker').datepicker('setValue', new Date());
      });
    </script>


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
