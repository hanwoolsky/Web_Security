<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css"  rel = "stylesheet"/>
    <title>Main Page</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_GET['session'])){
            session_destroy();
            echo "<script>window.location.href='index.php';</script>";
        }
        else if (isset($_SESSION['id'])){
    ?>  
    <div class = "column">
    <?php
            echo "<h2 class = \"text\">Welcome {$_SESSION['id']}!!</h2>";
    ?>
        <div class="btns">
    <?php
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'address.php'\"}>주소 검색</button>";
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'mypage.php'\"}>마이페이지</button>";
    ?>
        </div>
        <div class = "btns">
    <?php
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'board.php'\"}>게시판</button>";
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'qna_board.php'\"}>문의 게시판</button>";
    ?>
        </div>
    <?php
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'index.php?session=true'\"}>Logout</button>";
        }else{
    ?>
    </div>
    <div class = "column">
    <?php
        echo "<h2 class = \"text\">Welcome!!</h2>";
    ?>
        <div class = "btns">
    <?php
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'login.html'\"}>Login</button>";
            echo "<button class = \"writeBtn\"  onclick = \"location.href = 'qna_board.php'\"}>문의 게시판</button>";
            }
    ?>
        </div>
    </div>
</body>
</html>