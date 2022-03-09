<?php
    function print_result(){
        include 'conn.php';
        $conn = new mysqli($Server, $ID, $PW, $DBname);
        if(isset($_POST['addr']) && $_POST['addr'] != NULL){
            $sql = "SELECT * FROM address where road_name like ?";

            $pre_state = $conn->prepare($sql);
            $pre_state->bind_param("s", $addrs);

            $addrs = "%".$_POST['addr']."%";
            $pre_state->execute();

            $result = $pre_state->get_result();
            
            if($result){
                while($row = $result->fetch_array()){
                    echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
                }
            } else{
                echo "<script>alert('주소 없음.')</script>";
            }
            $pre_state->close();
        } else{
            echo "<tr><td>검색해주세요.</td><td>0</td></tr>";
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
                        session_start();
                        if (isset($_SESSION['id'])){
                            print_result();
                        }else{
                            echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>