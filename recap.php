<?php 
    session_start();
    ob_start();
    if(!isset($_SESSION["products"]) || empty($_SESSION["products"])){
        echo "<p class='txt'> Le panier est vide... </p>";
    }else{
?>
    <h1>Gestion des produits</h1>
    <?php
            echo "<table id='recapTable'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            $totalGeneral=0;

            foreach($_SESSION["products"] as $index => $product){
                echo "<tr id='blue'>
                        <td>".$index."</td>",
                        // "<td><img src='img/".$product["image"]."' width=200></td>",
                        "<td><a href='detail.php?id=".$index."'>".$product["name"]."</a></td>",
                        "<td>".$product["description"]."</td>",
                        "<td>".number_format($product["price"], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td><div class='qte'><a href='traitement.php?action=deleteOne&id=".$index."'>-</a>".$product["qte"]."<a href='traitement.php?action=addOne&id=".$index."'>+</a></div></td>",
                        "<td>".number_format($product["total"], 2, ",", "&nbsp;")."&nbsp;€</td>",
                        "<td class='delete'><a href='traitement.php?action=deleteProduct&id=".$index."'><i class='fa-regular fa-trash-can'></i></a></td>",
                    "</tr>";
                
                $totalGeneral+=$product["total"];
            }

            echo "<tr>
                    <td colspan=6 class='totalGeneral'><b>Total général :</b></td>
                    <td class='totalGeneral'><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</td>
                </tr>
                </tdbody>
                </table>
                <button class='button'><a href='traitement.php?action=deleteAll'>Vider le panier</button>";
        }
    ?>
</div>
<?php
    $content = ob_get_clean();
    require "template.php";
?>