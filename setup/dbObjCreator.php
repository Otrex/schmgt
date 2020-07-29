<?php

    function setUpDB($host, $dbname, $username, $password)
    {
        $f = fopen("../config/dbconfig.php", "w");

        $cont = "<?php \n\n";

        $cont .= "# This is created by an AutoLoader\n\n";

        $cont .= "$"."config = [];\n\n";

        $cont .= "$"."config['PDO_OBJECT'] = new PDO('mysql:host=$host;dbname=$dbname', '$username', '$password');\n\n";

        $cont .= "?>";

        fwrite($f, $cont);

        echo "<b> DataBase Has Been </b><br/><br/>";

    }

?>