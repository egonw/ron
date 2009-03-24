<?php

function get_content($url)
{
    $ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERPWD, "egonwillighagen:sunsunsu"); 

    ob_start();

    curl_exec ($ch);
    curl_close ($ch);
    $string = ob_get_contents();

    ob_end_clean();
   
    return $string;    
}

?>
