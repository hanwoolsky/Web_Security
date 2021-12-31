<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Comment</title>
</head>
<body>
    <div class = "column">
        <div class = "posting">
            <?php
                if(isset($_GET['id'])){
                    $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
                    $id = mysqli_real_escape_string($conn, $_GET['id']);
                    $sql = "SELECT * FROM qna where id = {$id}";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_array($result);
                    $title = $row['title'];
                    $content = $row['content'];
                    
                    mysqli_close($conn);
                }
            ?>
            <div class = "posting_title"><?=$title?></div>
            <div class = "posting_contents"><?=$content?></div>
            <form action = "qna_comment.php" method = "post">
                <div class = "posting">
                    <input name = "id" type = "hidden" value = "<?=$id?>"/>
                    <textarea class = "posting_title" name = "comment" placeholder = "댓글"></textarea>
                    <input class = "writeBtn" type = "submit" value = "create">
                </div>
            </form>
        </div>
    </div>
</body>
</html>