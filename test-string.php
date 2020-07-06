<?php

// your string.
$str = "php is good language than phpmyadmin";

// list of keywords that need to be highlighted.
$keywords = array('php','net','fun');

// iterate through the list.
foreach($keywords as $keyword) {

    // replace keyword with **keyword**
    $str = preg_replace("/($keyword)/i","naeem",$str);
}
echo $str;
?>