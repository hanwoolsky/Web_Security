<?php
    function print_result(){
        if(isset($_POST['addr']) && $_POST['addr'] != NULL){
            $addrs = $_POST['addr'];

            $conn = mysqli_connect('localhost', 'hacker', 'Hacker1234^', 'webpage');
            $sql = "SELECT * FROM address where road_name like '%$addrs%';";
            $result = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<tr><td>".$row['road_name']."</td><td>".$row['zipcode']."</td></tr>";
                }
            } else{
                echo "<script>alert('주소 없음.')</script>";
            }
            mysqli_close($conn);
        } else{
            echo "<tr><td>검색해주세요.</td><td>0</td></tr>";
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
    <title>Find address</title>
</head>
<body>
    <div class = "column">
        <div id = "search">
            <form method = "post">
                <input id = "search_addr" name = "addr" type = "text" placeholder="시, 구를 입력해주세요." />
                <input type = "submit" value = "🔍" id = "search_btn" />
            </form>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>road</th>
                        <th>zipcode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        print_result();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>