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
                include 'conn.php';
                $conn = new mysqli($Server, $ID, $PW, $DBname);
                session_start();
                if(isset($_GET['id'])){
                    $sql = "SELECT * FROM qna where id = ?";
                    $pre_state = $conn->prepare($sql);
                    $pre_state->bind_param("s", $id);

                    $id = $_GET['id'];
                    $pre_state->execute();

                    $result = $pre_state->get_result();
                    $row = $result->fetch_assoc();
                    $title = $row['title'];
                    $content = $row['content'];
                }
                mysqli_close($conn);
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