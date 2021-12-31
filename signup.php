<?php
    if(isset($_POST['signupid']) && isset($_POST['signuppw'])){
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $username = mysqli_real_escape_string($conn, $_POST['signupid']);
        $password = mysqli_real_escape_string($conn, $_POST['signuppw']);

        if ($username != NULL && $password != NULL){
            $sql = "INSERT INTO login (login_id, login_pw) VALUES ('$username', '$password');";
            
            if($result = mysqli_query($conn, $sql)){
                echo "<script>alert('회원가입 성공!')</script>";
                echo "<script>window.location.href='index.html';</script>";
            } else{
                echo "<script>alert('이미 존재하는 ID입니다.')</script>";
                echo "<script>window.location.href='signup.html';</script>";
            }
            mysqli_close($conn);
        } else{
            echo "<script>alert('아이디와 비밀번호를 입력해주세요.')</script>";
            echo "<script>window.location.href='signup.html';</script>";
        }
    }
?>