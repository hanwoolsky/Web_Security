<?php
    include 'conn.php';
    $conn = new mysqli($Server, $ID, $PW, $DBname);
    if(isset($_GET['id']) && isset($_GET['heart']) && isset($_GET['user'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $heart = mysqli_real_escape_string($conn, $_GET['heart']);
        $user = mysqli_real_escape_string($conn, $_GET['user']);

        $sql = "SELECT likes FROM board where username = '$user'";
        $likes_row = mysqli_fetch_array(mysqli_query($conn, $sql));
        $likes = $likes_row[0];
        if (strlen($likes) >= $id){
            $likes[$id-1] = strval($heart);
        }
        $likes_sql = "UPDATE board set likes = '$likes' where username = '$user'";
        mysqli_query($conn, $likes_sql);

        $sql = "SELECT likes_count FROM board where id = {$id}";
        $row = mysqli_fetch_array(mysqli_query($conn, $sql));
        $likes_count = $row[0];

        if ($heart){
            $view_sql = "UPDATE board set likes_count = likes_count + 1 where id = {$id}";
        } else{
            $view_sql = "UPDATE board set likes_count = likes_count - 1 where id = {$id}";
        }
        mysqli_query($conn, $view_sql);
        header('Location: read.php?id='.$id.'');
    }
    mysqli_close($conn);
?>