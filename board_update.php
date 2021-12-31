<?php
    if(isset($_POST['update_title']) && isset($_POST['update_body']) && isset($_POST['id']) && isset($_POST['update_title']) != NULL && isset($_POST['update_body']) != NULL && isset($_POST['id']) != NULL){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        session_start();
        if($_SESSION['id']) $username = $_SESSION['id'];

        $title = mysqli_real_escape_string($conn, $_POST['update_title']);
        $content = mysqli_real_escape_string($conn, $_POST['update_body']);

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
        
        $sql = "UPDATE board SET title = '$title', content = '$content', file = '$name' where id = '$id';";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글 수정에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        }
        mysqli_close($conn);
    }
?>