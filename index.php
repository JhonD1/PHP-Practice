<?php
require_once "pdo.php";
session_start();
?>

<h1>Welcome to Shopping Cart Database</h1>
<title>Jhon Daroing's Shopping Cart</title>

<?php
if(! isset($_SESSION['name'])){
    echo "<p>";
    echo "<a href='login.php'>Please log in. Password is php123</a>";
    echo "</p>";
    echo "<p>";
    echo "Attempt to go to "; 
    echo "<a href='add.php'>Add New</a> without logging in - it should fail with an error message. </p>";
    
}else{
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT * FROM cart");


    while( $rows = $stmt->fetch(PDO::FETCH_ASSOC))  {
        echo "<tr><td>";
        echo(htmlentities($rows['item']));
        echo("</td><td>");
        echo(htmlentities($rows['type']));
        echo("</td><td>");
        echo(htmlentities($rows['qty']));
        //echo("</td><td>");
        //echo('<a href="edit.php?cart_id='.$rows['cart_id'].'">Edit</a> / ');
        //echo('<a href="delete.php?cart_id='.$rows['cart_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }

    ?>
    </table>
    <p><a href="add.php">Add New Entry</a></p>
    <p><a href="logout.php">Logout</a></p>
    
    <?php 
} ?>