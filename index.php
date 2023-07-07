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
                <form action="add.php" method="POST" autocomplete="off">
                    <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                        <p><input type="text" name="title" class="form-control" placeholder="É necessário informar o nome da tarefa!"></p>
                        <p><button type="submit" class="btn btn-primary">Add <span>+</span></button></p>
                    <?php } else { ?>
                        <p><input type="text" name="title" class="form-control" placeholder="Clique para adicionar uma tarefa!"></p>
                        <p><button type="submit" class="btn btn-primary">Add <span>+</span></button></p>
                    <?php } ?>
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
                    <small>criado em: <?php echo $todo['date_time'] ?></small>
                </div>
                <?php } ?>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.remove-todo').click(function() {
                const id = $(this).attr('id');

                $.post('remove.php', 
                {
                    id: id
                }, 
                (data) => {
                    if(data) {
                        $(this).parent().hide(600);
                    }
                });
            });
            $('.checkbox').click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post('check.php', 
                {
                    id: id
                }, 
                (data) => {
                    if(data != 'error') {
                        const h2 = $(this).next();
                        if(data === '1') {
                            h2.removeClass('checked');
                        } else {
                            h2.addClass('checked');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>