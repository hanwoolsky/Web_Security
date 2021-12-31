<?php
    if(isset($_POST['create_title']) && isset($_POST['create_body']) && isset($_POST['create_title']) != NULL && isset($_POST['create_body']) != NULL){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        session_start();
        $title = mysqli_real_escape_string($conn, $_POST['create_title']);
        $content = mysqli_real_escape_string($conn, $_POST['create_body']);

        if(isset($_SESSION['id'])) $username = $_SESSION['id'];
        else $username = "";
        $sql = "SELECT login_pw FROM login where login_id = '$username';";
        
        if($result = mysqli_fetch_array(mysqli_query($conn, $sql))){
            $password = $result[0];
        }else{
            $password = $_POST['password'];
        }
        $sql2 = "INSERT INTO qna (username, title, content, password) VALUES ('$username', '$title', '$content', '$password');";

        if($result2 = mysqli_query($conn, $sql2)){
            echo "<script>alert('글 작성에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='qna_board.php';</script>";
        } else{
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>