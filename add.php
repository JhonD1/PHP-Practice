<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

if (isset($_POST["add_to_cart"])) {
    // Data validation
    $stmt = $pdo->prepare("SELECT COUNT(*) AS num FROM cart WHERE cart_id =:cid");
    $stmt->bindValue(':cid', $_POST['cart_id']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['num'] > 0){
        echo "found";
        $sql = "UPDATE cart SET qty = :qt
            WHERE cart_id = :cid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':qt' => $_POST['quantity'],
        ':cid' => $_POST['cart_id'])
        );
                
        $_SESSION['success'] = 'Record Added';
        header( 'Location: add.php' ) ;
        return;
    }
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>

<!-- view -->
<p><b>Add A New Item<b></p>


<?php 
$stmt = $pdo->query("SELECT * FROM cart");
while( $rows = $stmt->fetch(PDO::FETCH_ASSOC))  {
?>
<div style ="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align='center'> 
<form method="post">
    <p>Item:
    <?php echo(htmlentities($rows['item']));?></p>
    <p>Type:
    <?php echo(htmlentities($rows['type']));?></p>
    <p>Quantity:</p>
    <p><input type="text" name="quantity" value ="1"/></p>
    <p><input type="hidden" name="cart_id" value ="<?php echo $rows["cart_id"];?>"/></p>
    <p><input type="submit" name="add_to_cart" value="Add to Cart"/>
    </p>
</form>
</div>
<?php
}
?>
<p><a href="index.php">back to index</a></p>
<div>
    <b>Shopping List:<b>
    <?php

    echo('<table border="1">'."\n");
        $stmt = $pdo->query("SELECT * FROM cart");
        while( $rows = $stmt->fetch(PDO::FETCH_ASSOC))  {
            echo "<tr><td>";
            echo(htmlentities($rows['item']));
            echo("</td><td>");
            echo(htmlentities($rows['type']));
            echo("</td><td>");
            echo(htmlentities($rows['qty']));
            // echo("</td><td>");
            // echo('<a href="edit.php?cart_id='.$rows['cart_id'].'">Edit</a> / ');
            // echo('<a href="delete.php?cart_id='.$rows['cart_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }
    ?>
</div>

