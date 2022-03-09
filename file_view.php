<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();
    if(isset($_GET['id']) && isset($_SESSION['id'])){
        $sql = "SELECT username, file FROM board where id = ?";
        $pre_state = $conn->prepare($sql);
        $pre_state->bind_param("s",$id);

        $username = $_SESSION['id'];
        $id = $_GET['id'];
        $pre_state->execute();

        $row = $pre_state->get_result()->fetch_assoc();
        $user = $row['username'];
        $file_name = $row['file'];

        $sql_file = "SELECT * from upload where username = ? and file_name = ?";
        $pre_state_file = $conn->prepare($sql_file);
        $pre_state_file->bind_param("ss", $user, $file_name);
        $pre_state_file->execute();

        $result = $pre_state_file->get_result();
        if($row = $result->fetch_assoc()){
            $type = $row['type'];
            $image = $row['file'];
            echo '<img src="data:'.$type.';base64,'.base64_encode($image).'"/>';
        }else{
            echo "<script>alert('존재하지않는 파일입니다.');</script>";
            echo "<script>window.location.href='read.php?id=$id';</script>";
        }
    }
?>