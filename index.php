<?php 
require_once './core/model.php';
require_once './core/controller.php';
require_once './core/view.php'; 
?>
<!doctype html>
<html>
    <head>
        <meta charset="Windows-1251">
        <title>BeeJee - ToDo list</title>
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <script async src="./js/jquery-3.4.1.min.js"></script>
        <script async src="./js/popper.min.js"></script>
        <script async src="./js/bootstrap.min.js"></script>
        <style>
            body {
                background-image: linear-gradient(-45deg, rgba(200,200,200,0), rgba(230,230,100,0.7), rgba(200,200,200,1) );
                background-repeat: no-repeat;
                background-position: center top;
                background-attachment: fixed;
                background-color: #DCDCDC;
                }
            
}</style>
    </head>
    <body>
        <div class="container">
          <?
            buildNode(createNavMenu()); 
            buildNode(createList($allTasksSorted));
            buildNode(createModalInfo());
            buildNode(createModalTask());
            buildNode(createModalLogIn());
          ?>
        </div>
        <script>
          <? buildNode(createJS()); ?>
        </script> 
    </body>
</html>