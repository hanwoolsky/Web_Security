<?php
    if(isset($_POST['update_title']) && isset($_POST['update_body']) && isset($_POST['id']) && isset($_POST['update_title']) != NULL && isset($_POST['update_body']) != NULL && isset($_POST['id']) != NULL){
        $id = $_POST['id'];
        $title = $_POST['update_title'];
        $content = $_POST['update_body'];
        
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $sql = "UPDATE board SET title = '$title', content = '$content' where id = '$id';";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글 수정에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='board.php';</script>";
        }
        mysqli_close($conn);
    }
?>