
<?php 
  error_reporting(1);
  include "inc/dbutil.php";
 

  session_start();

  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
      header("Location: dashboard.php");
      exit;
  }
  $result = $conn->query("SELECT * FROM product");

  if (isset($_GET['id'])) {
    echo $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM product WHERE id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: products.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    
}

  
?>
<a href="product_add.php">Add New Product</a>
<form action="" method="post" id="frm1" name="frm1">
<table border="1">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <a href="product_edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <input type="button" value="Delete Product" onclick="validate('<?php echo $row['id']; ?>')">
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</form>
<?php
$conn->close();
?>
<script>
  function validate(id){
    if (confirm("Are you sure to delete!") == true) {
      var frm = document.frm1;					
      frm.action="products.php?id="+id;			 
      frm.submit(); 
    } 
  }
</script>
