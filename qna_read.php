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
            <?php
                include 'conn.php';
                $conn = new mysqli($Server, $ID, $PW, $DBname);
                session_start();
                if(isset($_GET['id'])){
                    $check = 1;
                    if(isset($_SESSION['id']) && $_SESSION['id'] == "admin") {
                        $sql = "SELECT * FROM qna where id = ?";
                        $pre_state = $conn->prepare($sql);
                        $pre_state->bind_param("s", $id);
                        $login_user = $_SESSION['id'];
                    }
                    else if(isset($_SESSION['id'])) {
                        $sql = "SELECT * FROM qna where id = ? and username = ?";
                        $pre_state = $conn->prepare($sql);
                        $pre_state->bind_param("ss", $id, $login_user);

                        $login_user = $_SESSION['id'];
                    } else if(isset($_SESSION['qnapw'])){
                        $sql = "SELECT * FROM qna where id = ? and password = ?";
                        $pre_state = $conn->prepare($sql);
                        $pre_state->bind_param("ss", $id, $password);

                        $password = $_SESSION['qnapw'];
                        $login_user = "";
                        unset($_SESSION['qnapw']);
                    } else{
                        $check = 0;
                    }
                    if ($check){
                        $id = $_GET['id'];
                        $pre_state->execute();
                        $result = $pre_state->get_result();

                        if($result->num_rows > 0){
                            $row = $result->fetch_assoc();
                            $title = $row['title'];
                            $content = $row['content'];
                            $comment = $row['comment'];
            ?>
                            <div class = "posting_title"><?=htmlentities($title)?></div>
                            <div class = "posting_contents"><?=htmlentities($content)?></div>
                            <div class = "posting_title"><?=htmlentities($comment)?></div>
                            <div class = "btns">
                                <button class = "writeBtn" onclick = "location.href = 'qna_board.php'">문의 게시판</button>
                                <?php
                                    if ($login_user == "admin") {
                                        echo "<button class = 'writeBtn' onclick = \"location.href = 'qna_answer.php?id=$id'\">댓글</button>";
                                    }
                                    else{
                                        $_SESSION['qnadelete'] = "delete";
                                        echo "<button class = 'writeBtn' onclick = \"location.href = 'qna_delete.php?id=$id'\">삭제</button>";
                                    }
                                ?>
                            </div>
            <?php
                        }else{
                            echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
                        }
                    }else{
                        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
                    }
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>