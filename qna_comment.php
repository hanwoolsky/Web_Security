<?php
    if(isset($_POST['comment']) && isset($_POST['id']) && isset($_POST['comment']) != NULL && isset($_POST['id']) != NULL){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $comment= mysqli_real_escape_string($conn, $_POST['comment']);
        
        $sql = "UPDATE qna SET comment = '$comment' where id = '$id';";

        if($result = mysqli_query($conn, $sql)){
            echo "<script>alert('글 작성에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='qna_board.php';</script>";
        } else{
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>