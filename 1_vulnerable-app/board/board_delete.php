<?php
    include '../conn.php';
    if(isset($_GET['id'])){
        $conn = mysqli_connect($Server, $ID, $PW, $DBname);
        session_start();
        $user = $_SESSION['id'];
        $id = $_GET['id'];
        $sql = "DELETE FROM board where id = {$id} and username='$user'";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글이 삭제되었습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        }
        mysqli_close($conn);
    }
?>
