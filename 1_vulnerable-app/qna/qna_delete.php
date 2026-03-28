<?php
    include '../conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM qna where id = {$id}";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글이 삭제되었습니다!')</script>";
            echo "<script>window.location.href='qna_board.php';</script>";
        }
        mysqli_close($conn);
    }
    mysqli_close($conn);
?>
