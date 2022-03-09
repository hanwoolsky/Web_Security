<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();
    if (isset($_SESSION['id'])){
        $id = $_SESSION['id'];

        $sql = "SELECT birthday FROM personal_info where login_id = '$id'";
        $row = mysqli_fetch_array(mysqli_query($conn, $sql));
        $birthday = $row[0];
    }else{
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    }
    mysqli_close($conn);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Private Page</title>
</head>
<body>
    <div class = "wrapper">
        <div id = "login-form">
            <div class = "head">개인정보</div>
            <form method = "post" action = "mypage_update.php">
                <div class = "hori">
                    <i class="far fa-user fa-2x"></i>
                    <input name = "id" type = "text" placeholder="<?=$id?>"/>
                </div>
                <div class = "hori">
                    <i class="fas fa-birthday-cake fa-2x"></i>
                    <input name = "birthday" type = "text" placeholder="<?=$birthday?>"/>
                </div>
                <div class = "hori">
                    <i class="fas fa-lock fa-2x"></i>
                    <input name = "pw" type = "password" placeholder="변경할 비밀번호"/>
                </div>
                <input name = "current_pw" id = "current_pw" type = "hidden"/>
                <div class = "hori"><input type = "submit" value = "Update" id = "signup-btnl" onClick="document.getElementById('current_pw').value = prompt('현재 비밀번호를 입력해주세요.', '비밀번호')"/></div>
            </form>
        </div>
    </div>
    <script
        src="https://kit.fontawesome.com/6478f529f2.js"
        crossorigin="anonymous"
    ></script>
</body>
</html>