<?php
    include 'conn.php';
    
    if(isset($_POST['id']) && isset($_POST['pw'])){
        $conn = new mysqli($Server, $ID, $PW, $DBname);
        if($_POST['id'] != NULL & $_POST['pw'] != NULL){
            $sql = "SELECT * FROM login where login_id = ? and login_pw = ?";

            $pre_state = $conn->prepare($sql);
            $pre_state->bind_param("ss", $username, $password);

            $username = $_POST['id'];
            $password = $_POST['pw'];
            $pre_state->execute();

            $result = $pre_state->get_result()->num_rows;
            if($result){
                session_start();
                $_SESSION['id'] = $username;
                header('Location: index.php');
            } else{
                echo "<script>alert('등록되지 않은 사용자입니다.')</script>";
                echo "<script>window.location.href='login.html';</script>";
            }
            $pre_state->close();
        } else{
            echo "<script>alert('아이디와 비밀번호를 입력해주세요.')</script>";
            echo "<script>window.location.href='login.html';</script>";
        }
    }
    mysqli_close($conn);
?>