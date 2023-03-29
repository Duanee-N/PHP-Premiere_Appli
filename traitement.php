<?php
session_start(); //$_session pour stocker des variables accessibles depuis n'importe quelle page (tant qu'on a "session_start()")
$id=$_GET["id"];
switch ($_GET['action']){
    case "addProduct":
        if(isset($_POST["submit"])) { //vérification de l'existence de la clé "submit" (= attribut name="submit") dans le tableau $_POST
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $qte = filter_input(INPUT_POST, "qte", FILTER_VALIDATE_INT);
            $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(isset($_FILES["image"])){
                $tmpName=$_FILES["image"]["tmp_name"];
                $nameimg=$_FILES["image"]["name"];
                $size=$_FILES["image"]["size"];
                $error=$_FILES["image"]["error"];
                $type=$_FILES["image"]["type"];
    
                $tabExtension=explode(".", $nameimg); //ici, explode() découpe une chaîne de caractères à chaque point (= ["ps5", "jpg"]) : permet de vérifier si c'est bien une image qui est upload
                $extension=strtolower(end($tabExtension)); //end() va récupérer le dernier élément du tableau
                $validExtension=["jpg", "jpeg", "gif", "png", "jfif"];
    
                if(in_array($extension, $validExtension)&&$error==0){ //si l'extension du fichier fait partie du tableau $validExtension, alors...
                    $uniqueName=uniqid("", true); //définir un nom unique pour éviter l'écrasement d'une autre image en cas de nom identique
                    $fileName=$uniqueName.".".$extension;
                    
                    move_uploaded_file($tmpName, "img/".$fileName); //déplacer l'image de $tmpName vers le dossier img
                }else{
                    $_SESSION["msg"] = "Erreur fichier ou extension... Veuillez réessayer.";
                }
    
            }

            $_SESSION["msg"] = "Le produit a été ajouté au panier"; //déclaration de variable sous la forme $_SESSION['exemple']
        }


        if($name && $description && $price && $qte){
            $product = [
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "qte" => $qte,
                "total" => $price * $qte,
                "image" => $fileName
            ];
            $_SESSION["products"][] = $product;

        } else{
            $_SESSION["msg"] = "Erreur... Veuillez réessayer.";
        }
        header("Location:index.php"); //redirection vers index.php grâce à la fonction header()
        die;

    case "deleteAll": //supprimer tous les produits du panier
        unset($_SESSION["products"]);
        header("Location:recap.php");
        die;

    case "deleteProduct": //supprimer un produit
        if(isset($_GET["id"])&&isset($_SESSION["products"][$_GET["id"]])){
            $_SESSION["msg"] = "Le produit a été supprimé du panier.";
            unset($_SESSION["products"][$_GET["id"]]);
        }
        header("Location:recap.php");
        die;

    case "addOne": //qte +1
        if(isset($_GET["id"])&&isset($_SESSION["products"][$_GET["id"]])){
            $_SESSION["products"][$_GET["id"]]["qte"]+=1;
            $_SESSION["products"][$_GET["id"]]["total"]=$_SESSION["products"][$_GET["id"]]["qte"]*$_SESSION["products"][$_GET["id"]]["price"];
        }
        header("Location:recap.php");
        die;

    case "deleteOne": //qte -1
        if(isset($_GET["id"])&&isset($_SESSION["products"][$_GET["id"]])){
            if($_SESSION["products"][$_GET["id"]]["qte"]==1){
                $_SESSION["msg"] = "Le produit a été supprimé du panier.";
                unset($_SESSION["products"][$_GET["id"]]);
            }else{
                $_SESSION["products"][$_GET["id"]]["qte"]-=1;
                $_SESSION["products"][$_GET["id"]]["total"]=$_SESSION["products"][$_GET["id"]]["qte"]*$_SESSION["products"][$_GET["id"]]["price"];
            }
        }
        header("Location:recap.php");
        die;
}
?>