<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="./src/css/styles.css">
</head>
<body>
    <?php require_once './src/database/dbconn.php'; ?>
    <div class="container">
        <h1>To-do List</h1>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-9">
                <form action="" method="POST" autocomplete="off">
                    <p><input type="text" name="title" class="form-control" placeholder="Clique para adicionar uma tarefa!"></p>
                    <p><button type="submit" class="btn btn-primary">Add <span>+</span></button></p>
                </form>
            </div>
            <div class="col-2"></div>
        </div>

        <?php 
            $dbo = new Database();
            $todos = $dbo -> conn -> query("select * from todos order by id desc");
        ?>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-9">

            <?php if ($todos -> rowCount() <= 0) { ?>
                <div class="todo-item">
                    <div class="empty">
                        <h1>Nenhuma Tarefa</h1>
                    <div>
                </div>
                <?php } ?>

                <?php while($todo = $todos -> fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>" class="remove-todo">x</span>
                    <?php if($todo['checked']) { ?>
                        <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="checkbox" checked>
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php } else { ?>
                        <input type="checkbox" data-todo-id="<?php echo $todo['id']; ?>" class="checkbox">
                        <h2><?php echo $todo['title'] ?></h2>
                        <?php } ?>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small>
                </div>
                <?php } ?>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</body>
</html>