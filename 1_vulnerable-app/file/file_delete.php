<?php
    include '../conn.php';
    if(isset($_GET['id'])){
        $conn = mysqli_connect($Server, $ID, $PW, $DBname);
        $id = $_POST['id'];
        
        $sql = "SELECT username, file from board where id = '$id';";
        $sql2 = "UPDATE board SET file = 'NULL' where id = '$id';";

        $result2 = mysqli_fetch_array(mysqli_query($conn, $sql));
        $username = $result2[0];
        $file = $result2[1];
        unlink("../files/$username/$file");

        if($result = mysqli_query($conn, $sql2)){
            echo "<script>alert('파일이 삭제되었습니다!')</script>";
            echo "<script>window.location.href='../board/read.php?id=$id';</script>";
        }
        mysqli_close($conn);
    }
?>
