<?php

function autoload($path,$root, $into, $backpath=false)
{

    $ent = "\n\n";
            
    $data = glob($root.'/'.$path.'/*.php');
    
    //print_r($data);
    sort($data);
    
    $new = fopen($into.".php", "w");
    
    
    $comment = "<?php".$ent.
               "// This is created by".
               " autoloader.".$ent;
            
    fwrite($new, $comment);
    
    echo "<h2>Autoloading files into <b>".ucwords($path)."</b>.....</h2><ul>";
    
    foreach($data as $d)
    {
        $d = explode('/', $d);
        
        //print_r($d);
        
        $d = $d[3];
        if ($backpath)
        {
            $item = "require_once '../app/".
            $path."/".$d."';".$ent;
            
        } else {
            $item = "require_once '".
            $path."/".$d."';".$ent;
        }
        echo "<li> <b>".ucfirst($d)."</b> loaded </li>";
        
        fwrite($new, $item);
    }

    echo "</ul>";
    
    fwrite($new, "?>");
    
    fclose($new);
    
}


?>