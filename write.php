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
        <form action = "board_create.php" method = "post" enctype="multipart/form-data">
            <div class = "posting">
                <input class = "posting_title" name = "create_title" type = "text" placeholder = "제목"/>
                <textarea class = "posting_contents" name = "create_body" placeholder = "내용"></textarea>
                <input class = "upload" name = "upload_file" type = "file" accept = "image/png, image/jpeg"/>
                <input class = "writeBtn" type = "submit" value = "create">
            </div>
        </form>
    </div>
</body>
</html>