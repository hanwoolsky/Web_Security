<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();
    if(isset($_POST['create_title']) && isset($_POST['create_body']) && isset($_POST['create_title']) != NULL && isset($_POST['create_body']) != NULL && isset($_SESSION['id'])){
        $title = mysqli_real_escape_string($conn, $_POST['create_title']);
        $content = mysqli_real_escape_string($conn, $_POST['create_body']);

        if($_SESSION['id']) $username = $_SESSION['id'];
        else $username = "anonymous";
        
        if($_FILES['upload_file']['tmp_name'] != NULL && $username != "anonymous"){
            $username = $_SESSION['id'];
            $tmp_name = $_FILES['upload_file']['tmp_name'];
            $size = getimagesize($_FILES['upload_file']['tmp_name']);
            $type = $size['mime'];
            $img = file_get_contents($_FILES['upload_file']['tmp_name']);
            
            $file_size = $_FILES['upload_file']['size'];
            $maxsize = 2000000;
            $name = $_FILES['upload_file']['name'];

            if($file_size < $maxsize){
                $sql = "INSERT INTO upload (username, file_name, file, size, type) VALUES (?, ?, ?, ?, ?)";
                $pre_state = $conn->prepare($sql);
                $pre_state->bind_param("sssss", $username, $name, $img, $file_size, $type);
                $pre_state->execute();
            }
        }else{
            $name = "NULL";
        }

        date_default_timezone_set('Asia/Seoul');
        $current_date = getdate();
        $date = $current_date["year"]."-".$current_date["mon"]."-".$current_date["mday"];
        $time = $current_date["hours"].":".$current_date["minutes"];
        if($username != "anonymous"){
            $sql = "INSERT INTO board (username, title, date, time, content, file) VALUES ('$username', '$title', '$date', '$time', '$content', '$name');";

            if($result = mysqli_query($conn, $sql)){
                echo "<script>alert('글 작성에 성공하셨습니다!')</script>";
                echo "<script>window.location.href='board.php';</script>";
            }
        }else{
            echo "<script>window.location.href='index.php';</script>";
        }
    }else{
        echo "<script>window.location.href='index.php';</script>";
    }
    mysqli_close($conn);
?>