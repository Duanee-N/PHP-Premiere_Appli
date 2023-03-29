<?php 
    session_start();
    ob_start();
?>
<h1>Ajouter un produit</h1>
<form action="traitement.php?action=addProduct" method="post" id="form" enctype="multipart/form-data">
    <div id="boxSection">
    <div class="box">
            <p>
                <label>
                    Image :
                    <input type="file" name="image" id="img-box">
                </label>
            </p>
        </div>
        <div class="box">
            <p>
                <label>
                    Nom du produit :
                    <input type="text" name="name" class="input">
                </label>
            </p>
        </div>
        <div class="box">
            <p>
                <label>
                    Prix du produit :
                    <input type="number" step="any" name="price" class="input">
                </label>
            </p>
        </div>
        <div class="box">
            <p>
                <label>
                    Quantité désirée :
                    <input type="number" name="qte" value="1" class="input">
                </label>
            </p>
        </div>
        <div class="box" id="description-box">
            <p>
                <label>
                    Description :
                    <textarea name="description" id="area"></textarea>
                </label>
            </p>
        </div>
    </div>
    <div id="submitBtn">
        <p>
            <input type="submit" name="submit" value="Ajouter au panier" class="button">
        </p>
    </div>
</form>
<?php
    $content = ob_get_clean();
    require "template.php";
?>