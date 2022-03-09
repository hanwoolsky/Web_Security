<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();
    if(isset($_SESSION['qnadelete'])){
        if(isset($_GET['id'])){
            $sql = "SELECT * FROM qna where id = ?";
            $pre_state = $conn->prepare($sql);
            $pre_state->bind_param("s", $id);

            $id = $_GET['id'];
            $pre_state->execute();

            $result = $pre_state->get_result()->num_rows;
            if($result){
                $sql2 = "DELETE FROM qna where id = ?";
                $pre_state = $conn->prepare($sql2);
                $pre_state->bind_param("s", $id);
                $pre_state->execute();
                echo "<script>alert('글이 삭제되었습니다!')</script>";
                echo "<script>window.location.href='qna_board.php';</script>";
            }
        }
        unset($_SESSION['qnadelete']);
    }else{
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    }
    mysqli_close($conn);
?>