<?php
    include 'conn.php';
    if(isset($_GET['id'])){
        $conn = new mysqli($Server, $ID, $PW, $DBname);
        $sql = "SELECT * from board where id = ? and username = ?";

        $pre_state = $conn->prepare($sql);
        $pre_state->bind_param("ss", $id, $user);

        session_start();
        $user = $_SESSION['id'];
        $id = $_GET['id'];
        $pre_state->execute();

        $result = $pre_state->get_result()->num_rows;
        if($result){
            $sql2 = "DELETE FROM board where id = ? and username = ?";
            $pre_state = $conn->prepare($sql2);
            $pre_state->bind_param("ss", $id, $user);
            $pre_state->execute();
            echo "<script>alert('글이 삭제되었습니다.')</script>";
        }else{
            echo "<script>alert('글을 삭제할 수 없습니다.')</script>";
        }
        echo "<script>window.location.href='board.php';</script>";
        $pre_state->close();
        mysqli_close($conn);
    }
?>