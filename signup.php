<?php
    include 'conn.php';
    if(isset($_POST['signupid']) && isset($_POST['signuppw'])){
        $conn = new mysqli($Server, $ID, $PW, $DBname);
        $username = $_POST['signupid'];
        $password = $_POST['signuppw'];
        if ($username != NULL && $password != NULL){
            $sql = "INSERT INTO login (login_id, login_pw) VALUES (?, ?)";

            $pre_state = $conn->prepare($sql);
            $pre_state->bind_param("ss", $username, $password);

            if($pre_state->execute()){
                echo "<script>alert('회원가입 성공!')</script>";
                echo "<script>window.location.href='index.php';</script>";
            }else{
                echo "<script>alert('이미 존재하는 ID입니다.')</script>";
                echo "<script>window.location.href='signup.html';</script>";
            }
            $pre_state->close();
        } else{
            echo "<script>alert('아이디와 비밀번호를 입력해주세요.')</script>";
            echo "<script>window.location.href='signup.html';</script>";
        }
        mysqli_close($conn);
    }
?>