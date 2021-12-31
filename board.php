<?php
    function board(){
        if(isset($_POST['board_result'])){
            $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
            $find = mysqli_real_escape_string($conn, $_POST['board_result']);
            $column = mysqli_real_escape_string($conn, $_POST['option_val']);
            $start_date = mysqli_real_escape_string($conn, $_POST['date_from']);
            $end_date = mysqli_real_escape_string($conn, $_POST['date_to']);

            if($start_date && $end_date){
                $sql = "SELECT * FROM board where $column like '%$find%' and date between '$start_date' and '$end_date';";
            }
            else $sql = "SELECT * FROM board where $column like '%$find%';";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<tr><td>".$row['username']."</td><td><a href = \"read.php/?id=".$row['id']."\"&view=1>".$row['title']."</a></td><td>".$row['views']."</td><td>".$row['date']."</td></tr>";
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
            <form method = "post">
                <select name = "option_val">
                    <option value = "username">작성자</option>
                    <option value = "title">제목</option>
                    <option value = "content">내용</option>
                </select>
                <input id = "search_addr" name = "board_result" type = "text" placeholder="Search" />
                <input type = "submit" name = "board_search" value = "🔍" id = "search_btn" />
                <i class="far fa-calendar-alt"></i><input type = "date" name ="date_from" />
                <i class="far fa-calendar-alt"></i><input type = "date" name = "date_to" />
            </form>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Title</th>
                        <th>Views</th>
                        <th>Date</th>
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
                            if(array_key_exists('board_search', $_POST)){
                                board();
                            }
                            else{
                                $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
                                $sql = "SELECT * FROM board limit $start_data, 10;";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_array($result)){
                    ?>
                                    <tr>
                                        <td><?=$row['username']?></td>
                                        <td><a href = 'read.php?id=<?=$row['id']?>&view=1'><?=$row['title']?></a></td>
                                        <td><?=$row['views']?></td>
                                        <td><?=$row['date']?></td>
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
        <button class = "writeBtn" onclick = "location.href = 'write.php'">글쓰기</button>
        <div class = "paginations">
            <?php
                $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
                $sql = "SELECT * FROM board;";
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