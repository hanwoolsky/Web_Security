<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();
    if(isset($_GET['id']) && isset($_SESSION['id'])){
        $sql = "SELECT file from board where id = ? and username = ?";
        $pre_state = $conn->prepare($sql);
        $pre_state->bind_param("ss", $id, $username);
        
        $id = $_GET['id'];
        $username = $_SESSION['id'];
        $pre_state->execute();

        $result = $pre_state->get_result();

        $sql2 = "UPDATE board SET file = 'NULL' where id = ?";
        $pre_state2 = $conn->prepare($sql2);
        $pre_state2->bind_param("s", $id);

        if($row = $result->fetch_array()){
            $file = $row[0];
            $sql3 = "DELETE from upload where username = ? and file_name = ?";
            $pre_state3 = $conn->prepare($sql3);
            $pre_state3->bind_param("ss", $username, $file);

            if($result2 = $pre_state2->execute() && $result3 = $pre_state3->execute()){
                echo "<script>alert('파일이 삭제되었습니다!')</script>";
                echo "<script>window.location.href='read.php?id=$id';</script>";
            }
        }else{
            echo "<script>alert('삭제 권한이 없습니다!')</script>";
            echo "<script>window.location.href='read.php?id=$id';</script>";
        }
    }
    mysqli_close($conn);
?>