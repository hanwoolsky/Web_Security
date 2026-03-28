<?php
    include '../conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    session_start();

    if(isset($_GET['id']) && isset($_GET['heart']) && isset($_SESSION['id'])){

        // [SECURE] user를 GET 파라미터가 아닌 세션에서 가져옴 (IDOR 방어)
        $id    = intval($_GET['id']);
        $heart = intval($_GET['heart']);
        $user  = $_SESSION['id'];

        if($id <= 0 || !in_array($heart, [0, 1])){
            header('Location: read.php?id=' . $id);
            exit;
        }

        $sql   = "SELECT likes FROM board WHERE username = ?";
        $stmt  = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $likes_row = $stmt->get_result()->fetch_array();
        $likes = $likes_row ? $likes_row[0] : str_repeat("0", 1000);

        if(strlen($likes) >= $id){
            $likes[$id - 1] = strval($heart);
            $update_sql  = "UPDATE board SET likes = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $likes, $user);
            $update_stmt->execute();
        }

        if($heart){
            $count_sql = "UPDATE board SET likes_count = likes_count + 1 WHERE id = ?";
        } else{
            $count_sql = "UPDATE board SET likes_count = likes_count - 1 WHERE id = ?";
        }
        $count_stmt = $conn->prepare($count_sql);
        $count_stmt->bind_param("i", $id);
        $count_stmt->execute();

        header('Location: read.php?id=' . $id);
    }
    mysqli_close($conn);
?>