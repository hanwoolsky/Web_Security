<?php
    if(isset($_GET['id'])){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        session_start();
        $user = $_SESSION['id'];
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM board where id = {$id} and username='$user'";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글이 삭제되었습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        }
        mysqli_close($conn);
    }
?>