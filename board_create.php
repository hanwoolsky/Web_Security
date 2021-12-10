<?php
    if(isset($_POST['create_title']) && isset($_POST['create_body']) && isset($_POST['create_title']) != NULL && isset($_POST['create_body']) != NULL){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        session_start();
        //$title = $_POST['create_title'];
        //$content = $_POST['create_body'];
        $title = mysqli_real_escape_string($conn, $_POST['create_title']);
        $content = mysqli_real_escape_string($conn, $_POST['create_body']);

        if($_SESSION['id']) $username = $_SESSION['id'];
        else $username = "anonymous";
        
        if($_FILES['upload_file'] != NULL){
            $tmp_name = $_FILES['upload_file']['tmp_name'];
            $name = $_FILES['upload_file']['name'];
            $path = "./files/$username";
            if(!file_exists($path)){
                mkdir($path, 0777, true);
                chmod($path, 0777);
                $up = move_uploaded_file($tmp_name, "$path/$name");
            }else{
                $up = move_uploaded_file($tmp_name, "$path/$name");
            }
        }else{
            $name = "NULL";
        }

        date_default_timezone_set('Asia/Seoul');
        $current_date = getdate();
        $date = $current_date["year"]."-".$current_date["mon"]."-".$current_date["mday"];
        $time = $current_date["hours"].":".$current_date["minutes"];

        $sql = "INSERT INTO board (username, title, date, time, content, file) VALUES ('$username', '$title', '$date', '$time', '$content', '$name');";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글 작성에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        } else{
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>