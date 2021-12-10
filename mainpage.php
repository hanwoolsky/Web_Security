<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_GET['session'])){
            session_destroy();
            echo "<script>window.location.href='index.html';</script>";
        }
        else if (isset($_SESSION['id'])){
            echo "<h2>Welcome {$_SESSION['id']}!! This is Main Page.</h2>";
            echo "<button id = 'addr-btn' onclick = \"location.href = 'address.php'\"}>주소 검색</button>";
            echo "<button id = 'addr-btn' onclick = \"location.href = 'mypage.php'\"}>마이페이지</button>";
            echo "<button id = 'signup-btn' onclick = \"location.href = 'board.php'\"}>게시판</button>";
    ?>
    <button onClick = "document.location.href = 'mainpage.php?session=true';">Logout</button>
    <?php
        }else{
            echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
        }
    ?>
</body>
</html>