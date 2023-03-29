<?php 
    session_start();
    ob_start();
    
    if(isset($_GET["id"])&&isset($_SESSION["products"][$_GET["id"]])){
        echo "<div id='detail-container'><h1>".$_SESSION["products"][$_GET["id"]]["name"]."</h1>
        <div id='detail-content'><img src='img/".$_SESSION["products"][$_GET["id"]]["image"]."' width=200>
        <div id='detail'><p class='txt'>Description : ".$_SESSION["products"][$_GET["id"]]["description"]."</p>
        <p class='txt'>Prix : ".$_SESSION["products"][$_GET["id"]]["price"]." €</p></div></div></div>";
    }

$content = ob_get_clean();
require "template.php";
?>