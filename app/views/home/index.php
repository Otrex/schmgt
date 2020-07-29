<?php

    require "home.htm";

    if (isset($_GET["msg"]))
    {
        echo "<script> var msg = '".$_GET["msg"]."'; </script>";
        // Create a classs later
        require_once "message.htm";

    }

    

?>