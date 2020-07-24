<?php

function setDirectories($root)
{
    # $root = "http://localhost/schmgt.edu"

    # For the javaScript
    $js = fopen("../static/setup.js", "w");

    $content = "/* This is created By SetDirectories */ \n\n";

    $content.= "const schmgt = {};\n\n";

    $content.= "schmgt.rootDir = '$root'; \n\n";

    fwrite($js, $content);

    echo "<b> JsSetup Created Successfully</b><br><br>";


    # For the PHP
    $php = fopen("../app/core/Globals.php", "w");

    $content = "<?php \n\n";

    $content.= "/* This is created By SetDirectories */ \n\n";

    $content.= "$"."indexDir = '$root/public'; \n\n";

    $content.= "$"."rootDir = '$root/'; \n\n?>";

    fwrite($php, $content);

    echo "<b> PhPSetup Created Successfully</b>";
    // $indexDir = "http://localhost/schmgt.edu/public";
    
    // $rootDir = "http://localhost/schmgt.edu/";
    
}
?>