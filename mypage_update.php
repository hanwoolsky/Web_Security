<?php
    $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
    $cur_pw = mysqli_real_escape_string($conn, $_POST['current_pw']);
    session_start();
    $id = $_SESSION['id'];

    $login_sql = "SELECT * FROM login where login_id = '$id' and login_pw = '$cur_pw';";
    if($result = mysqli_fetch_array(mysqli_query($conn, $login_sql))){
        if($_POST['id'] != NULL){
            $new_id = mysqli_real_escape_string($conn, $_POST['id']);
        }else{
            $new_id = $id;
        }

        if($_POST['birthday'] != NULL){
            $new_birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
        } else{
            $sql = "SELECT birthday FROM personal_info where login_id = '$id'";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql));
            $new_birthday = $row[0];
        }

        if($_POST['pw'] != NULL){
            $new_pw = mysqli_real_escape_string($conn, $_POST['pw']);
        }else{
            $sql = "SELECT login_pw FROM login where login_id = '$id'";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql));
            $new_pw = $row[0];
        }

        $update_sql1 = "UPDATE personal_info SET login_id = '$new_id', birthday = '$new_birthday' where login_id = '$id';";
        $update_sql2 = "UPDATE login SET login_pw = '$new_pw' where login_id = '$id';";
        if($result1 = mysqli_query($conn, $update_sql1) && $result2 = mysqli_query($conn, $update_sql2)){
            echo "<script>alert('회원 정보 수정에 성공하셨습니다!')</script>";
            echo "<script>window.location.href='mainpage.php';</script>";
        }

    } else{
        echo "<script>alert('비밀번호가 일치하지 않습니다.')</script>";
        echo "<script>window.location.href='mypage.php';</script>";
    }
    mysqli_close($conn);
?>