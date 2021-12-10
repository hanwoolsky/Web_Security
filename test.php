<?php
    function board(){
        if(isset($_POST['board_result'])){
            $find = $_POST['board_result'];
            $column = $_POST['option_val'];

            $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
            $sql = "SELECT * FROM board where $column like '%$find%';";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<tr><td>".$row['username']."</td><td><a href = \"read.php/?id=".$row['id']."\">".$row['title']."</a></td><td>".$row['views']."</td><td>".$row['date']."</td></tr>";
                }
            } else{
                echo "<script>alert('존재하지 않습니다.')</script>";
            }
            mysqli_close($conn);
        }
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
        <div id = "search">
            <form method = "get">
                <select name = "option_val">
                    <option value = "username">이름</option>
                    <option value = "title">제목</option>
                    <option value = "content">내용</option>
                    <option value = "date">날짜</option>
                </select>
                <input id = "search_addr" name = "board_result" type = "text" placeholder="Search" />
                <input type = "submit" name = "board_search" value = "🔍" id = "search_btn" />
            </form>
            <?php
                if(isset($_GET['board_result'])){
                    echo "<div id = 'test'>".$_GET['board_result']."는 존재하지 않습니다.</div>";
                }
            ?>
        </div>
        <div style = "height: 100px"></div>
        <div id = "login-form">
            <div class = "head">Log In</div>
            <form action = "login.php" method = "post">
                <div class = "hori">
                    <i class="far fa-user fa-2x"></i>
                    <input name = "id" type = "text" placeholder="Email" id = "login-id" />
                </div>
                <div class = "hori">
                    <i class="fas fa-lock fa-2x"></i>
                    <input name = "pw" type = "password" placeholder="Password" id = "login-pw" />
                </div>
                <div class = "hori"><input type = "submit" value = "Log In" id = "login-btn" /></div>
            </form>
            <button id = "signup-btn" onclick = "location.href = 'signup.html'">Sign up</button>
        </div>
    </div>
</body>
</html>