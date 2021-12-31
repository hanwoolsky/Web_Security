<?php
    $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
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
            <?php
                session_start();
                if(isset($_SESSION['id'])) {
                    $login_user = $_SESSION['id'];
                } else{
                    $login_user = "anonymous";
                }
                if(isset($_GET['id'])){
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $sql = "SELECT * FROM qna where id = {$id}";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_array($result);
                    $title = $row['title'];
                    $content = $row['content'];
                    $comment = $row['comment'];

                    mysqli_close($conn);
                }
            ?>
            <div class = "posting_title"><?=$title?></div>
            <div class = "posting_contents"><?=$content?></div>
            <div class = "posting_title"><?=$comment?></div>
            <div class = "btns">
                <button class = "writeBtn" onclick = "location.href = 'qna_board.php'">문의 게시판</button>
                <?php
                    if ($login_user == "admin") {
                        echo "<button class = 'writeBtn' onclick = \"location.href = 'qna_answer.php?id=$id'\">댓글</button>";
                    }
                    else{
                        echo "<button class = 'writeBtn' onclick = \"location.href = 'qna_delete.php?id=$id'\">삭제</button>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>