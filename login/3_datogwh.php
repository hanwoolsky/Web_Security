<?php
    if(isset($_POST['id']) && isset($_POST['pw'])){
        $username = $_POST['id'];
        $password = $_POST['pw'];

        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $sql = "SELECT * FROM login where login_id = '$username' and hash_pw = sha2('$password', 256);";
        
        if($result = mysqli_fetch_array(mysqli_query($conn, $sql))){
            session_start();
            $_SESSION['id'] = $username;
            header('Location: mainpage.php');
        } else{
            echo "<script>alert('등록되지 않은 사용자입니다.')</script>";
            echo "<script>window.location.href='index.html';</script>";
        }
        mysqli_close($conn);
    } else{
        echo "<script>alert('아이디와 비밀번호를 입력해주세요.')</script>";
        echo "<script>window.location.href='index.html';</script>";
    }
?>