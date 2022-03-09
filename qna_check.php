<?php
    session_start();
    if(isset($_SESSION['id'])) {
        $login_user = $_SESSION['id'];
    } else{
        $login_user = "anonymous";
    }
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    if(isset($_GET['id'])){
        $sql = "SELECT * FROM qna where id = ?";
        $pre_state = $conn->prepare($sql);
        $pre_state->bind_param("s", $id);
        $id = $_GET['id'];
        $pre_state->execute();

        $result = $pre_state->get_result();
        $row = $result->fetch_assoc();
        $username = $row['username'];
    }
    mysqli_close($conn);
    if ($login_user == "admin" || $login_user == $username){
        echo "<script>window.location.href='qna_read.php?id=$id';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Read Posting</title>
</head>
<body>
    <div class = "column">
        <div class = "posting">
            <form method = "post">
                <input id = "anonypw" name = "anonypw" type = "text" placeholder="Password" />
                <input type = "submit" name = "pw_check" value = "🔍" id = "search_btn" />
            </form>
            <?php
                if(array_key_exists('pw_check', $_POST)){
                    $pw = $_POST['anonypw'];
                    $_SESSION['qnapw'] = $pw;
                    include 'conn.php';
                    $conn = new mysqli($Server, $ID, $PW, $DBname);
                    if(isset($_GET['id'])){
                        $id = mysqli_real_escape_string($conn, $_GET['id']);

                        $sql = "SELECT * FROM qna where id = ?";
                        $pre_state = $conn->prepare($sql);
                        $pre_state->bind_param("s", $id);

                        $pre_state->execute();
                        $result = $pre_state->get_result();
                        $row = $result->fetch_assoc();
                        $password = $row['password'];
                    }
                    mysqli_close($conn);

                    if($pw == $password){
                        echo "<script>window.location.href='qna_read.php?id=$id';</script>";
                    }else{
                        echo "<script>alert('확인할 수 없습니다.')</script>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>