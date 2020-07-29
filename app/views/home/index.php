<?php

//print_r($_GET);
    if (isset($_GET["msg"]))
    {
        switch ($_GET["msg"]) {
            case '404':
                echo "<script> alert('Login In Failed Due to incorrect `password` or `username`'); </script>";
                break;
            
            case '300':
                echo "<script> alert('You Have Signed Out'); </script>";
                break;

                case '300':
                    echo "<script> alert('You Have Signed Out'); </script>";
                    break;
            default:
                echo "<script> alert('". $data["msg"]. "'); </script>";
                break;
        }

    }

    require "home.htm";

?>