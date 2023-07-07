<?php
    if(isset($_POST['title'])) {
        require_once './src/database/dbconn.php';

        $title = $_POST['title'];

        try {

            if(empty($title)) {
                header('Location: index.php?mess=error');
            } else {
                $dbo = new Database();
                $stmt = $dbo -> conn -> prepare('insert into todos (title) value(?)');
                $res = $stmt -> execute([$title]);
    
                if($res) {
                    header('Location: index.php?mess=success');
                } else {
                    header('Location: index.php');
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