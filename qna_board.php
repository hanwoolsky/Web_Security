<?php
    function myqna(){
        $username = $_SESSION['id'];
        $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
        $sql = "SELECT * from qna where username = '$username' order by id desc;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                echo "<tr><td>".$row['id']."</td><td><a href = \"qna_check.php/?id=".$row['id']."\">".$row['title']."</a></td></tr>";
            }
        } else{
            echo "<script>alert('존재하지 않습니다.')</script>";
        }
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
    <title>Q&A Board</title>
</head>
<body>
    <div class = "column">
        <?php
            session_start();
            if(isset($_SESSION['id'])){
                $username = $_SESSION['id'];
            }else{
                $username="";
            }
            if($username){
                echo "
                    <div class = ''>
                        <form method = 'post'>
                            <p>나의 문의</p>
                            <input type = 'submit' name = 'qna_search' value = '🔍' id = 'search_btn' />
                        </form>
                    </div>
                ";
            }
        ?>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(array_key_exists('page', $_POST)){
                            printpage($_POST['page']);
                        }
                        else{
                            printpage(1);
                        }
                        function printpage(int $page){
                            $start_data = ($page - 1) * 10;
                            if(array_key_exists('qna_search', $_POST)){
                                myqna();
                            }
                            else{
                                $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
                                $sql = "SELECT * from qna order by id desc limit $start_data, 10;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_array($result)){
                    ?>
                                    <tr>
                                        <td><?=$row['id']?></td>
                                        <td><a href = 'qna_check.php?id=<?=$row['id']?>'><?=$row['title']?></a></td>
                                    </tr>
                    <?php
                                }
                                mysqli_close($conn);
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <button class = "writeBtn" onclick = "location.href = 'qna.php'">문의하기</button>
        <div class = "paginations">
            <?php
                $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
                $sql = "SELECT * from qna order by id desc;";
                $result = mysqli_query($conn, $sql);

                $data_num = mysqli_num_rows($result);
                $page_num = ceil($data_num / 10);
            ?>
                <form method = "post">
                    <?php
                        for($i = 1; $i <= $page_num; $i = $i+1){
                            echo "<input type = 'submit' class = 'pagination' name = 'page' value = '$i'/>";
                        }
                    ?>
                </form>
        </div>
    </div>
    <script
        src="https://kit.fontawesome.com/6478f529f2.js"
        crossorigin="anonymous"
    ></script>
</body>
</html>