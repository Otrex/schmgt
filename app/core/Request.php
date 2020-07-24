<?php

class Request 
{
    public static function uri()
    {
	if (isset($_GET["url"]))
        {
            $uri = explode (
                "/", 

                filter_var(
                    rtrim(
                        $_GET["url"],
                        "/"
                    ),
                    FILTER_SANITIZE_URL 
                )
            );
            
            return $uri = array_values($uri);

        }

    }

    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}
?>
