<?php
    if(isset($_POST['id'])) {
        
        require_once './src/database/dbconn.php';

        $id = $_POST['id'];

        try {

            if(empty($id)) {
                echo 'error';
            } else {
                $dbo = new Database();
                $todos = $dbo -> conn -> prepare('select id, checked from todos where id=?');
                $todos -> execute([$id]);

                $todo = $todos -> fetch();
                $uId = $todo['id'];
                $checked = $todo['checked'];

                $uChecked = $checked ? 0 : 1;

                $res = $dbo -> conn -> prepare('update todos set checked=? where id=?');
                $res -> execute([$uChecked, $uId]);

                if($res) {
                    echo $checked;
                } else {
                    echo 'error';
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