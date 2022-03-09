<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    if(isset($_POST['update_title']) && isset($_POST['update_body']) && isset($_POST['id']) && isset($_POST['update_title']) != NULL && isset($_POST['update_body']) != NULL && isset($_POST['id']) != NULL){
        session_start();
        if($_SESSION['id']) $username = $_SESSION['id'];

        $title = mysqli_real_escape_string($conn, $_POST['update_title']);
        $content = mysqli_real_escape_string($conn, $_POST['update_body']);

        if($_FILES['upload_file']['tmp_name'] != NULL && $username != "anonymous"){
            $username = $_SESSION['id'];
            $tmp_name = $_FILES['upload_file']['tmp_name'];
            $size = getimagesize($_FILES['upload_file']['tmp_name']);
            $type = $size['mime'];
            $img = file_get_contents($_FILES['upload_file']['tmp_name']);
            
            $file_size = $_FILES['upload_file']['size'];
            $maxsize = 2000000;
            $name = $_FILES['upload_file']['name'];

            $sql = "SELECT file from board where id = ?";
            $pre_state = $conn->prepare($sql);
            $pre_state->bind_param("s", $id);

            $id = $_POST['id'];
            $pre_state->execute();

            $result = $pre_state->get_result();
            $row = $result->fetch_assoc();
            $file_name = $row['file'];
            if($file_name == "NULL" && $file_size < $maxsize){
                $sql2 = "INSERT INTO upload (username, file_name, file, size, type) VALUES (?, ?, ?, ?, ?)";
                $pre_state2 = $conn->prepare($sql2);
                $pre_state2->bind_param("sssss", $username, $name, $img, $file_size, $type);
                $pre_state2->execute();
            } else if($file_size < $maxsize){
                $sql2 = "UPDATE upload set file_name = ?, file = ?, size = ?, type = ? where username = ?, file_name = ?";
                $pre_state2 = $conn->prepare($sql2);
                $pre_state2->bind_param("ssssss", $name, $img, $file_size, $type, $username, $file_name);
                $pre_state2->execute();
            }
            $pre_state->close();
            $pre_state2->close();
        }else{
            $name = "NULL";
        }
        
        $sql3 = "UPDATE board SET title = '$title', content = '$content', file = '$name' where id = ?";
        $pre_state3 = $conn->prepare($sql3);
        $pre_state3->bind_param("s", $id);

        $id = $_POST['id'];

        if($pre_state3->execute()){
            echo "<script>alert('글 수정에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        }
        $pre_state3->close();
    }
    mysqli_close($conn);
?>