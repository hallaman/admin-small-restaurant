<?php

function show_message($type, $text) 
{
   return "<p class=\"$type\"><span>$text</span></p>";
}

function imageButtonClicked($button) 
{
    return $button > 0;
}



?>