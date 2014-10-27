<?php

   define ('DAILY_MENU_SECTION', 'Daily Menu');
   define ('SUB_SECTION_COL', 'Sub Section');
   define ('MENU_DATE', 'Date');
   define ('MENU_TAG_LINE', 'Tag Line');
    
   
   $menu = new websiteMenuClass();
   $menu->showMenu();
   
   class websiteMenuClass
   {   
      var $menuFields      = array();
      var $menuData        = array();
      var $menuPublished   = true;
      var $menuDate        = null;
      var $menuTagLine     = null;
      
      function websiteMenuClass()
      {
         $this->readMenu();
      }
      
      
      function showMenuFooter()
      {?>
         </table><?php
      }
      
      function showMenuHeader()
      {
         $month      = null;
         $day        = null;
         $year       = null;
         $menuDate   = null;?>

         <table class='wsmTable' align='center'><?php
         
         if (!$this->menuPublished)
         {?>
            <tr><td><p class='wsmNoMenu' >The Daily Menu is not currently published.<br>Please check back soon.</p></td></tr><?php
            return;
         }
         
         foreach ($this->menuData[DAILY_MENU_SECTION] as $menuKey => $menuItem)
         {
            if ($menuItem[SUB_SECTION_COL] == MENU_DATE)
            {
               list($month, $day, $year) = explode("/", $menuItem['Entry']);
               $this->menuDate = mktime(0, 0, 0, $month, $day, $year);              
            }
            elseif ($menuItem[SUB_SECTION_COL] == MENU_TAG_LINE)
            {
               $this->menuTagLine = $menuItem['Entry'];
            }            
         }
         
         echo "Menu Date".  $this->menuDate . ' ' . $this->menuTagLine;
         
         
         
         
         
//          list($month, $day, $year) = explode("/", $fields[$row]['Item']);
//                         $menuDate = mktime(0,0,0, $month, $day, $year);         
//          $dateNow = date('y/m/d', mktime()); 
//          $dateForm = "<span style='font-size: 140%'>Daily Menu for ".date('l, F jS, Y', $menuDate)."</span>"; 
//          $trailer = '';
//                
//          if ($menuTagLine)
//          {
//             $trailer .= "<br><span style='font-size: 100%;'>&mdash; ".$menuTagLine." &mdash;</span>"; 
//          }
//                         
//          if ($menuDate > $dateNow)
//          {
//             $trailer .= "<p style='margin-bottom: 0px'><strong><span style='font-size: 100%;'>Note: This Daily Menu is for the above upcoming date and subject to change!</span></p>";
//          }
//          elseif ($menuDate < $dateNow)
//          {
//             $trailer .= "<p style='margin-bottom: 0px'><strong><span style='font-size: 100%;'>Note: The Daily Menu for today has not been posted.</strong><br>Please check back soon!</span></p>";
//          }?>
         <tr>
            <td style="padding: 8px; background-color: #ABD1A1; border: 1px solid #387C25; font-size: 100%; font-weight: normal; letter-spacing: 1px;" align="center" colspan="3"><?php // echo $dateForm.$trailer;?></td>
         </tr><?php



      
      }
      
      function showMenu()
      {
         $this->showMenuHeader();
         $this->showMenuFooter();

         
         echo "<pre>";
         print_r($this->menuData);
         print_r($this->menuFields);
         echo "</pre>";
   


      }
      
      private function readMenu()
      {
         $data          = null;
         $row           = null;
         $lastSection   = null;
         
         if (($handle = fopen("../data/website-menu.csv", "r")) !== FALSE) 
         {
            while (($data = fgetcsv($handle, 8192, ",")) !== FALSE) 
            {
               $num = count($data);
               if (is_null($row))
               {               
                  for ($c = 0; $c < $num; $c++) 
                  {
                     $this->menuFields[$c] = $data[$c];
                  }
               }
               else
               {
                  if ($data[0] == '')
                  {
                     continue;
                  }
                  if ($data[0] != $lastSection)
                  {
                     $row = 0;
                     $lastSection = $data[0];
                  }
                  if (!isset($this->menuData[$lastSection]))
                  {
                     $this->menuData[$lastSection] = array();
                  }
                  for ($c=0; $c < $num; $c++) 
                  {
                     $this->menuData[$lastSection][$row][$this->menuFields[$c]] = $data[$c];
                     
                  }
                  if ($this->menuData[$lastSection][$row]['Published'] != 'Yes')
                  {                                                                                    
                  
                     if ($lastSection == DAILY_MENU_SECTION && $this->menuData[$lastSection][$row][SUB_SECTION_COL] == MENU_DATE)
                     {
                        $this->menuPublished = false;
                        break;
                     }
                  
                     unset($this->menuData[$lastSection][$row]);
                     $row--;
                  }
               }
                  
                  $row++;
            }
            fclose($handle);
         }

      }
   
   }

?>
