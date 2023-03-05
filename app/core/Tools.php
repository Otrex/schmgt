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
            //echo $msg;

            if ($msg != 0)
            {
                header ("Location: ../home/index?msg=$msg");

                die();

                return null;

            }

            header ("Location: ..");

            die();
            
        }

        public static function redirect_to_dashboard()
        {
            header("Location: dashboard");

            die();
        }

        public static function redirect($r)
        {
            header ("Location: ../".$r);

            die();
        }

        public static function redirect_to($r, $msg=null)
        {
            if (stristr($r, ".htm") || stristr($r, ".html"))
            {
                header ("Location: $r".($msg ? "?msg=".$msg : ""));

                die();
            }

            header ("Location: $r".($msg ? "/home?msg=".$msg : ""));

            die();
        }

    }

//     //////////////////////////////////////////////////////////////////////


    trait InputManip
    {
        public static function cleanInput($data)
        {
            //die($data);
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

        public static function consoleLog($data, $key = false)
        {
            echo "<script> console.log('".json_encode($data)."')</script>";

            if ($key) {die();}
        }

        public static function createNewId($model, $data="")
        {
            $yr = "".date("Y");

            $yr = substr($yr, 2,2);

            $lid = $model->getLastId($data) ?? "/-1";

            $md = end(explode("/", $lid));

            $md = intval($md) + 1;

            return isset($model->staffTypes) ? sprintf("ccis/1/%02s/%'03s", $yr,$md): sprintf("ccis/0/%02s/%'03s", $yr,$md);
        }

        public static function test($x = "Working")
        {
            return $x;
        }

        public function randomizer($key, $partlength = 100)
        {
            return substr($key, 1, $partlength).(floor(rand()*(1/10000000))).substr($key, 6, $partlength);
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
                extract($_FILES);
                $fileTmpPath = $inputName['tmp_name'];
    
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