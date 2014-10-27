<?php

   function readMenu()
   {
   
         $menuDate = null;
         $menuTagLine = null;
         
         $row = 0;
         $fields = array();
         
         if (($handle = fopen("data/daily-menu.csv", "r")) !== FALSE) 
         {
            while (($data = fgetcsv($handle, 8192, ",")) !== FALSE) 
            {
               $num = count($data);
               $fields[$row] = array();
               
               for ($c=0; $c < $num; $c++) 
               {
                  if ($row == 0)
                  {
                     $fields[$row][$c] = $data[$c];
                  }
                  else
                  {
                     $fields[$row][$fields[0][$c]] = $data[$c];
                  }
               }
               
               if ($row > 0)
               {
                  if ($fields[$row]['Published'] != "Yes")
                  {
                     if ($fields[$row]['Section'] == 'Daily Menu' && $fields[$row]['Sub Section'] == 'Date')
                     {
                        echo "<p style=\"font-weight: bold; text-align: center; padding: 8px; background-color: #ABD1A1; border: 1px solid #387C25; font-size: 100%; letter-spacing: 2px;\">The Daily Menu is not currently published.<br>Please check back soon.</p>";
                        fclose($handle);
                        return;
                     }
                     unset($fields[$row]);
                     $row--;
                  }
   
                  elseif ($fields[$row]['Section'] == 'Daily Menu')
                  {
                     if ($fields[$row]['Sub Section'] == 'Date')
                     {
                        list($month, $day, $year) = explode("/", $fields[$row]['Item']);
                        $menuDate = mktime(0,0,0, $month, $day, $year);
                     }
                     elseif ($fields[$row]['Sub Section'] == 'Tag Line')
                     {
                        $menuTagLine = $fields[$row]['Item'];
                     }
                  }
               }
               
               $row++;
            }
            fclose($handle);
         }
         
         if ($row > 0)
         {
            unset($fields[0]);
         }?>
         
         <!-- Begin Menu Table -->
         
         <table width="662px" align="center" style="background-color: #CFE0C9;"><?php
         
         $dateNow = date('y/m/d', mktime()); 
         $dateForm = "<span style='font-size: 140%'>Daily Menu for ".date('l, F jS, Y', $menuDate)."</span>"; 
         $trailer = '';
               
         if ($menuTagLine)
         {
            $trailer .= "<br><span style='font-size: 100%;'>&mdash; ".$menuTagLine." &mdash;</span>"; 
         }
                        
         if ($menuDate > $dateNow)
         {
            $trailer .= "<p style='margin-bottom: 0px'><strong><span style='font-size: 100%;'>Note: This Daily Menu is for the above upcoming date and subject to change!</span></p>";
         }
         elseif ($menuDate < $dateNow)
         {
            $trailer .= "<p style='margin-bottom: 0px'><strong><span style='font-size: 100%;'>Note: The Daily Menu for today has not been posted.</strong><br>Please check back soon!</span></p>";
         }?>
         <tr>
            <td style="padding: 8px; background-color: #ABD1A1; border: 1px solid #387C25; font-size: 100%; font-weight: normal; letter-spacing: 1px;" align="center" colspan="3"><?php echo $dateForm.$trailer;?></td>
         </tr>
         
         <?php placeLeaderItems("Today's Highlights", $fields); ?> 
         <?php placeLeaderItems('Main Features', $fields); ?> 
         <?php placeLeaderItems('Farm Fresh Bar', $fields); ?> 

         <tr>
            <td colspan="3" align="center">&nbsp;</td>
         </tr>
         <!--         
         <tr>
            <td style="border-top: 1px solid #84B477; border-bottom: 1px solid #84B477; background-color: #CBDBC5;" align="center" colspan="3"><span style='font-size: 140%; font-weight: bold; letter-spacing: 3px; color: #276B14; '>FARM FRESH BAR</span><br>
            <span style=''>Mix and match any way you please &mdash; Dishes change daily</span><br>
            <span style='font-size: 120%; color: #C9323C;'>&bull;</span>&nbsp;Hot Well Item&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size: 120%; color: #32A3C9;'>&bull;</span>&nbsp;Cold Well Item
            </td>
         </tr>
         --><?php

         $lastItem = "";?>
                  
         <tr><td align="center" valign="top" width="50%"><?php

         echo "<p style='border-bottom: 1px solid #BF4A4A; color: #BF4A4A; letter-spacing: 2px; padding: 6px; margin: 12px 32px 12px 32px; font-size: 110%; font-style: normal; font-weight: bold;'>Hot Items</p>";
         // echo "<p style='font-size: 86%; font-style: italic; font-weight: bold;'>Items are individually priced</p>";
         
         echo "<div style='color: #BF4A4A;'>";
         foreach ($fields as $key => $item)
         {
            if ($item['Sub Section'] == 'Hot Items')
            {
               placeFarmFreshItem($item, &$lastItem);
            }
         }
         echo "</div>";
            
         ?></td><td width="20px">&nbsp;</td><td align="center" valign="top" width="50%"><?php

         echo "<p style='border-bottom: 1px solid #4A88BF; color: #4A88BF; letter-spacing: 2px; padding: 6px; margin: 12px 32px 12px 32px; font-size: 110%; font-style: normal; font-weight: bold;'>Cold Items</p>";
         //echo "<p style='font-size: 86%; font-style: italic; font-weight: bold;'>Items are &#36;3.00 each</p>";
         
         $lastItem = "";
         
         echo "<div style='color: #4A88BF;'>";
         foreach ($fields as $key => $item)
         {
            if ($item['Sub Section'] == 'Cold Items')
            {
               placeFarmFreshItem($item, &$lastItem);
            }
         }
         echo "</div>";
                     
         ?></td></tr>
         
         <tr><td colspan="3">&nbsp;</td></tr>
         <tr><td style="border-top: 1px solid #579346; border-bottom: 1px solid #579346; font-size: 140%; font-weight: bold; letter-spacing: 3px; color: #276B14; background-color: #CBDBC5;" align="center" colspan="3">TO GO COOLER</td></tr>
         <!-- <tr><td colspan="3">&nbsp;</td></tr> -->

         <tr><td align="center" valign="top" colspan="3"><?php

         echo "<p style='font-size: 100%; font-style: italic; font-weight: normal;'>You can request any item to go.<br>Several items are also available prepacked in our to-go cooler.</p>";?>
         
         </td></tr><?php

         $trailer = "<strong>*Choose a side:</strong> <br>apple sauce, yogurt stick, veggies & hummus, rice, <br>or any item from our Farm Fresh Bar";
         placeLeaderItems('Kids Meals', $fields, $trailer); 
         placeLeaderItems('Drinks', $fields); 
         placeLeaderItems('Desserts', $fields); 
         placeLeaderItems('Other', $fields); ?>

         <tr><td align="center" valign="top" colspan="3">&nbsp;</td></tr>
         <tr><td colspan="3" style="font-weight: bold; text-align: center;">~ End of the Daily Menu ~</td></tr>
         <tr><td align="center" valign="top" colspan="3">&nbsp;</td></tr>

         </table>
         
         <!-- End Menu Table --><?php

      }


   function placeFarmFreshItem($item, &$last)
   {
      $repeatItem = false;
      
      if ($last)
      {
         echo "<br style='line-height: 60%'>";
      }
      
//       if ($item['Sub Section'] == 'Hot Items')
//       {
//          //$location = "<span style='font-size: 120%; color: #C9323C;'>&bull;&nbsp;</span>";
//       }
//       elseif ($item['Location'] == 'Cold Well')
//       {
//          //$location = "<span style='font-size: 120%; color: #32A3C9;'>&bull;&nbsp;</span>";
//       }
//       else
//       {
         $location = '';
//      }
      
      $title = getTitle($item);
      
      if (strpos($item['Item'], ":"))
      {
         list($generic, $current) = explode(':', $item['Item']);
         if ($generic != $last)
         {
            if ($last)
            {
               echo "<br style='line-height: 60%'>";
            }
            if ($item["Today's Highlights"] == "Yes")
            {
               $style = "color: #E28204; font-weight: bold; font-style: italic; font-size: 90%;";

            }
            else
            {
               $style="";
            }
            //echo "<strong>".$location.$generic."</strong>".":<br><i><span title=\"$title\" style=\"$style\">".$current."</span></i>";
            echo "$generic:<br><i><span title=\"$title\" style=\"$style\">".infoTitle($current, $title)."</span></i>";
            //echo "<span class='collapsible'><span class='collapsible_title' title='Click to toggle info'><strong>".$location.$generic."</strong></span><span></span></span><div class='collapsible_text'>$title</div>";
         }
         else
         {
            $repeatItem = true;
         }
         $last = $generic;
      }
      else
      {
         if ($item['Item'] != $last)
         {
            if ($last)
            {
               echo "<br style='line-height: 60%'>";
            }
            //echo "<strong>".$location."<span title=\"$title\">".$item['Item']."</span></strong>";
            echo infoTitle($item['Item'], $title);
            
            //echo "<span class='collapsible'><span onmouseover='highlightDetails(this);' onmouseout='dimDetails(this);' class='collapsible_title' title='Click to toggle info'><strong>".$location.$item['Item']."</strong></span><span></span></span><div class='collapsible_text'>$title</div>";
            
//       .collapsible h4.collapse-open {background: url(images/open.png) no-repeat;}
//       .collapsible h4.collapse-close {background: url(images/close.png) no-repeat;}
//       
//       h4.collapsible {width: 100%; margin: 6px 0 6px 0; float: left; cursor: pointer;}
//       
//       h4.collapse-open div{ float: left; background: url(images/close.png) no-repeat scroll 2px 5px transparent; width: 26px; height: 21px; margin-left: 2px;}
//       h4.collapse-close div { float: left; background: url(images/open.png) no-repeat scroll 2px 5px transparent; width: 26px; height: 21px; margin-left: 2px;}              
         }
         else
         {
            $repeatItem = true;
         }
         $last = $item['Item'];
      }
      
      if ($item['Option'])
      {
         if ($repeatItem)
         {
            echo "&sdot; <i>{$item['Option']}</i>";
         }
         else
         {
            echo "<br>&sdot; <i>{$item['Option']}</i>";
         }
      }
      
//       if ($item['Sub Section'] == 'Specialty Creations')
//       {
//          echo "<span style='font-size: 86%;'><br>~ &#36;".number_format($item['Price'], 2)." ~</span>";
//       }
      
   }

   function infoTitle($item, $title)
   {
      return "<span class='collapsible'><span onmouseover='highlightDetails(this);' onmouseout='dimDetails(this);' class='collapsible_title' title='Click to toggle info'>$item</span><span></span></span><div class='collapsible_text'>$title</div>";   
   }
   
   
   function getTitle($item)
   {
      $title = '';
      $contains = '';
      
      if ($item['Description'])
      {
         $title .= "<span style='font-size: 90%; color: #000;'>".$item['Description']."</span>";
      }   
      if (($item['Contains Gluten'] == 'Yes'))
      {
         $contains .= "Gluten, ";
      }
      if (($item['Contains Soy'] == 'Yes'))
      {
         $contains .= "Soy, ";
      }
      if (($item['Contains Nuts'] == 'Yes'))
      {
         $contains .= "Nuts, ";
      }
      if (($item['Contains Dairy'] == 'Yes'))
      {
         $contains .= "Dairy, ";
      }
      if ($contains)
      {
         $contains = substr($contains, 0, -2);
         $title .= "<br><span style='color: red; font-size: 80%; font-weight: bold;'>Contains: $contains".'!</span>'; 
      }
      if (!$title)
      {
         $title .= "<span style='color: red; font-size: 80%; font-weight: bold;'>Info N/A</span>"; 
      }
      
      return "<div class='menuDetails' >$title</div>";
      
   }
   
   function placeLeaderItems($section, $fields, $trailer = '')
   {?>
      <tr><td colspan="3">&nbsp;</td></tr>
      <!-- <tr><td colspan="3">&nbsp;</td></tr> --><?php
      
      if ($section != "Today's Highlights")
      {
         $backgroundColor = "#CBDBC5";
         $tagLine = "";
      }
      else
      {
         $backgroundColor = "#E8E3A2";
         $tagLine = "<br><span style='font-weight: normal; letter-spacing: 0px; text-transform:none; font-style: italic; font-size: 65%;'>This section lists our daily menu changes and specials all in one place for convenience.<br>These items are also found individually throughout the various sections of our menu.</span>";
      }?>

      <tr><td style="border-top: 1px solid #84B477; border-bottom: 1px solid #84B477; font-size: 140%; font-weight: bold; letter-spacing: 3px; text-transform:uppercase; background-color: <?php echo $backgroundColor; ?>; color: #276B14; " align="center" colspan="3"><?php echo $section; echo $tagLine ? $tagLine : "";?></td></tr>
      <!-- <tr><td colspan="3" >&nbsp;</td></tr> -->

      <tr><td align="left" valign="top" colspan="3"><?php
      
      $lastItem = '';
      $indent = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      
      foreach ($fields as $key => $item)
      {

         if ($section == "Today's Highlights")
         {
            $sectionName = " (<span style='font-style: normal; letter-spacing: 0px; font-size: 75%;'>".$item['Section']."</span>)";
         }
         else
         {
            $sectionName = "";
         }
      
         if (strpos($item['Item'], ":"))
         {
            list($generic, $current) = explode(':', $item['Item']);
            $sep = ": ";
         }
         else
         {
            $generic = $item['Item'];
            $sep = "";
            $current = "";
         }

         $title = getTitle($item);
      
         
         $itemName = $generic.$sectionName.$sep."<span style='color: #E28204; font-weight: bold; font-style: italic; font-size: 100%;'>".infoTitle($current, $title)."</span>";
               
         if ( ($item['Section'] == $section && $item['Sub Section'] == '') || ($section == "Today's Highlights" && $item["Today's Highlights"] == 'Yes'))
         {
            if ($item['Option'])
            {
               if ($item['Item'] != $lastItem)
               {?><tr><td colspan="3"><span title="<?php echo $item['Description'];?>"><?php echo $itemName;?></span></td></tr><?php
               }?>
               <tr style="background: url(images/period-leader.png) repeat-x scroll 0 6px transparent;"><td colspan="3" ><div style="float: left; background-color: #CFE0C9;"><?php echo $indent.$item['Option'];?>&nbsp;</div><div style="float: right; background-color: #CFE0C9;">&nbsp;<?php echo "&#36;".number_format($item['Price'], 2);?></div></td></tr><?php
            }
            else
            {?>
               <tr style="background: url(images/period-leader.png) repeat-x scroll 0 6px transparent;"><td colspan="3" ><div  title="<?php echo $item['Description'];?>" style="float: left; background-color: #CFE0C9;"><?php echo $itemName;?>&nbsp;</div><div style="float: right; background-color: #CFE0C9;">&nbsp;<?php echo "&#36;".number_format($item['Price'], 2);?></div></td></tr><?php
            }
            //else
            
            $lastItem = $item['Item'];
         }
      }
      
      if ($trailer != '')
      {?>
      <tr><td colspan="3"><p style='text-align: center; margin-bottom: 0px; margin-top: 0px; font-size: 86%; font-style: italic; font-weight: normal;'><?php echo $trailer;?></p></td></tr><?php
      }?>
      
      <?php
   }

   function junk()
   {?>
      <tr><td align="left" valign="top" colspan="3">
      
      <ul class=leaders><?php

      $lastItem = '';
      $indent = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      
      foreach ($fields as $key => $item)
      {
         if ($item['Section'] == $section)
         {
            if ($item['Option'])
            {
               if ($item['Item'] != $lastItem)
               {?><li class="listheader"><?php echo $item['Item'];?></li><?php
               }?>
               <li><span><?php echo $indent.$item['Option'];?></span><span class="price"><?php echo "&#36;".number_format($item['Price'], 2);?></span></li><?php
            }
            else
            {?>
               <li><span><?php echo $item['Item'];?></span><span class="price"><?php echo "&#36;".number_format($item['Price'], 2);?></span></li><?php
            }
            $lastItem = $item['Item'];
         }
      }
      
      if ($trailer)
      {?>
      <p style='text-align: center; margin-bottom: 0px; font-size: 86%; font-style: italic; font-weight: normal;'><?php echo $trailer;?></p><?php
      }?>
      
      </td></tr><?php   }
?>
