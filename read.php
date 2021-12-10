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
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM board where id = {$id}";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_array($result);
                    $username = $row['username'];
                    $title = $row['title'];
                    $content = $row['content'];
                    $likes_count = $row['likes_count'];
                    $file_name = $row['file'];

                    if(isset($_GET['view'])){
                        $view_sql = "UPDATE board set views = views + 1 where id = {$id}";
                        mysqli_query($conn, $view_sql);
                    }

                    session_start();
                    $login_user = $_SESSION['id'];
                    $likes_sql = "SELECT likes FROM board where username = '$login_user'";

                    $likes_row = mysqli_fetch_array(mysqli_query($conn, $likes_sql));
                    $likes = $likes_row[0];
                    
                    mysqli_close($conn);
                }
            ?>
            <div class = "posting_title"><?=$title?></div>
            <div class = "posting_contents"><?=$content?></div>
            <?php
                if ($likes[$id-1] == 1){
            ?>      <div class = "likes">
                        <a href = 'likes.php?id=<?=$id?>&heart=0&user=<?=$login_user?>'><i class="fas fa-heart red fa-2x"></i></a>
                        <span class = "likes_count"><?=$likes_count?></span>
                    </div>
            <?php
                } else{
            ?>      <div class = "likes">
                        <a href = 'likes.php?id=<?=$row['id']?>&heart=1&user=<?=$login_user?>'><i class="far fa-heart white fa-2x"></i></a>
                        <span class = "likes_count"><?=$likes_count?></span>
                    </div>
            <?php
                }
                $path = "./files/$username/$file_name";
                if(file_exists($path)){
            ?>
                    <div class = "file_links">
                        <a href="http://localhost/web_dev/files/<?=$username?>/<?=$file_name?>" target="_blank">View</a>
                        <a href="./files/<?=$username?>/<?=$file_name?>" download = "<?=$file_name?>">Download</a>
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