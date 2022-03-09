<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    if(isset($_POST['comment']) && isset($_POST['id']) && isset($_POST['comment']) != NULL && isset($_POST['id']) != NULL){
        $comment= mysqli_real_escape_string($conn, $_POST['comment']);
        
        $sql = "UPDATE qna SET comment = '$comment' where id = ?;";
        $pre_state = $conn->prepare($sql);
        $pre_state->bind_param("s", $id);

        $id = $_POST['id'];
    
        if($pre_state->execute()){
            echo "<script>alert('글 작성에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='qna_board.php';</script>";
        } else{
            echo mysqli_error($conn);
        }
    }
    mysqli_close($conn);
?>