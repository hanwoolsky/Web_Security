<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM board where id = {$id}";

        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $content = $row['content'];
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Free Talking</title>
</head>
<body>
    <div class = "column">
        <form action = "board_update.php" method = "post" enctype="multipart/form-data">
            <div class = "posting">
                <input name = "id" type = "hidden" value = "<?=$id?>"/>
                <input class = "posting_title" name = "update_title" type = "text" value = "<?=$title?>" />
                <textarea class = "posting_contents" name = "update_body"><?=$content?></textarea>
                <input class = "upload" name = "upload_file" type = "file" accept = "image/png, image/jpeg"/>
                <input class = "writeBtn" type = "submit" value = "update">
            </div>
        </form>
    </div>
</body>
</html>