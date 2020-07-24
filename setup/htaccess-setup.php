<?php

function create($base)
{
    $ext = "\n";

    $htfile = fopen("../public/.htaccess", "w");

    $data = "Options -MultiViews".$ext.
    "RewriteEngine On".$ext.
    
    "RewriteBase ".$base.$ext.
    "RewriteCond %{REQUEST_FILENAME} !-f".$ext.
    "RewriteCond %{REQUEST_FILENAME} !-d".$ext.
    
    "RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]";

    fwrite($htfile, $data);

    echo "<b>Access Control file Created..<b><br><br>";
}


function x ()
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        return $actual_link."/schoolmgt/".$src;
}

?>