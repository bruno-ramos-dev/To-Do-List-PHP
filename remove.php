<?php
    if(isset($_POST['id'])) {

        require_once './src/database/dbconn.php';

        $id = $_POST['id'];

        try {
            if(empty($id)) {
                echo 0;
            } else {
                $dbo = new Database();
                $stmt = $dbo -> conn -> prepare('delete from todos where id = ?');
                $res = $stmt -> execute([$id]);
    
                if($res) {
                    echo 1;
                } else {
                    echo 0;
                }
    
                $dbo = null;
                exit();
            }
        } catch (Exception $ee) {
            echo ($ee -> getMessage(). '<br>');
        }
    } else {
        header('Location: index.php?mess=error');
    }
?>