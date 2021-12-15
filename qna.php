<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Q&A</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['id'])) {
            $flag = 0;
        } else{
            $flag = 1;
        }
    ?>
    <script>
        function get_pw(){
            var flag = <?php echo $flag ?>;
            if(flag){
                document.getElementById('password').value = prompt('비밀번호를 입력해주세요.', '비밀번호');
            }
        }
    </script>
    <div class = "column">
        <form action = "qna_create.php" method = "post" enctype="multipart/form-data">
            <div class = "posting">
                <input class = "posting_title" name = "create_title" type = "text" placeholder = "제목"/>
                <textarea class = "posting_contents" name = "create_body" placeholder = "내용"></textarea>
                <input name = "password" id = "password" type = "hidden"/>
                <input class = "writeBtn" type = "submit" value = "create" onClick="get_pw()">
            </div>
        </form>
    </div>
</body>
</html>