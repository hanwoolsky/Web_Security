<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
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
                if(isset($_GET['id']) && isset($_SESSION['id'])){
                    $sql = "SELECT * FROM board where id = ?";

                    $pre_state = $conn->prepare($sql);
                    $pre_state->bind_param("s", $id);

                    $id = $_GET['id'];
                    $pre_state->execute();

                    $result = $pre_state->get_result();

                    $row = $result->fetch_assoc();
                    $username = $row['username'];
                    $title = $row['title'];
                    $content = $row['content'];
                    $likes_count = $row['likes_count'];
                    $file_name = $row['file'];

                    if(isset($_GET['view'])){
                        $view_sql = "UPDATE board set views = views + 1 where id =  ?";
                        $pre_state = $conn->prepare($view_sql);
                        $pre_state->bind_param("s", $id);
                        $pre_state->execute();
                    }

                    $login_user = $_SESSION['id'];
                    $likes_sql = "SELECT likes FROM board where username = '$login_user'";

                    $likes_row = mysqli_fetch_array(mysqli_query($conn, $likes_sql));
                    if($likes_row){
                        $likes = $likes_row[0];
                    }else{
                        $likes = "0"*1000;
                    }
                    
                    mysqli_close($conn);
                }else{
                    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
                }
            ?>
            <div class = "posting_title"><?=htmlentities($title)?></div>
            <div class = "posting_contents"><?=htmlentities($content)?></div>
            <?php
                if (strlen($likes) >= $id){
                    if ($likes[$id-1] == 1){
            ?>      
                        <div class = "likes">
                            <a href = 'likes.php?id=<?=$id?>&heart=0&user=<?=$login_user?>'><i class="fas fa-heart red fa-2x"></i></a>
                            <span class = "likes_count"><?=$likes_count?></span>
                        </div>
            <?php
                    } else{
            ?>      
                        <div class = "likes">
                            <a href = 'likes.php?id=<?=$row['id']?>&heart=1&user=<?=$login_user?>'><i class="far fa-heart white fa-2x"></i></a>
                            <span class = "likes_count"><?=$likes_count?></span>
                        </div>
            <?php
                    }
                }
                if($file_name != NULL){
            ?>
                    <div class = "file_links">
                        <a href="file_view.php?id=<?=$id?>" target="_blank">View</a>
                        <a href="file_download.php?id=<?=$id?>">Download</a>
                        <a href="file_delete.php?id=<?=$id?>">Delete</a>
                    </div>
            <?php
                }
            ?>
            <div class = "btns">
                <button class = "writeBtn" onclick = "location.href = 'board.php'">게시판</button>
                <?php
                    if ($login_user == $username) {
                        echo "<button class = 'writeBtn' onclick = \"location.href = 'update.php?id=$id'\">수정</button>";
                        echo "<button class = 'writeBtn' onclick = \"location.href = 'board_delete.php?id=$id'\">삭제</button>";
                    }
                ?>
            </div>
        </div>
    </div>
    <script
        src="https://kit.fontawesome.com/6478f529f2.js"
        crossorigin="anonymous"
    ></script>
</body>
</html>