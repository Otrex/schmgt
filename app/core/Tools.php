<?php
//msg code

/*

404 === Error

300 === Succesful Logging out
*/
    trait Session
    {
        public static function isLoggedIn()
        {
            if (isset($_SESSION["usrId"]))
            {
                return true;
            }

            Tools::endSession(202);
        }

        public static function makeSession($data)
        {
            $_SESSION["usrId"] = $data;
        }

        public static function endSession($msg = 0)
        {
            session_unset();
            
            session_destroy();
            
            Tools::redirect_to_home($msg);

        }
    }



// ////////////////////////////////////////////////////////////////////////

    trait Redirect
    {
        public static function redirect_to_home ($msg = 0)
        {
            if ($msg != 0)
            {
                header ("Location: ../?msg=$msg");

                die();

            }

            header ("Location: ..");

            die();
            
        }

        public static function redirect_to_dashboard()
        {
            header("Location: ../dashboard");

            die();
        }

        public static function redirect($r)
        {
            header ("Location: ../".$r);

            die();
        }

        public static function redirectScript($url="/")
        {
            global $indexDir;

            $p = $indexDir;

            if ($url == "home" ||$url == "/")
            {
                header ("Location: ..");
            }
            
            echo "<script> location.assign('".$p.$url."');</script>";
        }
    }

//     //////////////////////////////////////////////////////////////////////


    trait InputManip
    {
        public static function cleanInput($data)
        {
            $data = trim($data);
            
            $data = stripslashes($data);
            
            $data = htmlspecialchars($data);
            
            return $data;
        }

        public static function stringify($data)
        {
            return "'".Tools::cleanInput($data)."'";
        }
    }
    

//     ///////////////////////////////////////////////////

    class Tools
    {
        use Session, Redirect, InputManip;

        public static function test($x = "Working")
        {
            return $x;
        }
 
        public static function getPosted(){
            return json_decode(file_get_contents("php://input"), true);
        }

        public static function uploadPath($x){
            return "../../uploads/".$x;
        }

        public static function retrievePicture($data, $type, $full=0){

            switch ($full) {
                case 0:
                    foreach ($data as $value) {
                        $value->picture = Tools::uploadPath("images/".$type."/".$value->picture);
                    };
                    break;
                
                default:
                    foreach ($data as $value) {
                        $value->member->picture = Tools::uploadPath("images/".$type."/".$value->member->picture);
                    };
                    break;
            }
            

            return $data;
        }

        public static function uploadFile($inputName, $type, $specified = "img")
        {
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {

                $fileTmpPath = $_FILES[$inputName]['tmp_name'];
    
                $fileName = $_FILES[$inputName]['name'];
    
                $fileSize = $_FILES[$inputName]['size'];
    
                $fileType = $_FILES[$inputName]['type'];
    
                $fileNameCmps = explode(".", $fileName);
    
                $fileExtension = strtolower(end($fileNameCmps));
    
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = '../upload/'.$type;
    
                    $dest_path = $uploadFileDir . $newFileName;
                    
                    if(move_uploaded_file($fileTmpPath, $dest_path))
                    {
                        return isset($_FILES["owner"]) ? ["Id" => $_FILES["owner"] ,"filename" => $newFileName] : $newFileName;

                    } else {
                        
                        return false;
                    }
                }
            }
        }
    }
    
?>