
<?php 
  error_reporting(1);
  include "inc/dbutil.php";
 session_start();

 if (!isset($_SESSION['user_id'])) {
     header("Location: login.php");
     exit;
 }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $price = $_POST['price'];
  $status='1';
  if (empty($name) || !is_numeric($price)) {
      die("Invalid input");
  }

  $stmt = $conn->prepare("UPDATE product SET name=?, price=? WHERE id=?");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("sdi", $name, $price, $id);
  if ($stmt->execute()) {
      header("Location: products.php");
  } else {
      echo "Error: " . $stmt->error;
  }
  $stmt->close();
  $conn->close();
}
else{
  $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT name, price FROM product WHERE id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $price);
    $stmt->fetch();
    
}

?>
<a href="products.php">List Product</a>
<form action="" method="post" id="frm" name="frm">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Name: <input type="text" name="name" id="name" value="<?php echo $name; ?>" required><br>
    Price: <input type="text" name="price" id="price" value="<?php echo $price; ?>" required><br>
    <input type="button" value="Update Product" onclick="validate()">
</form>

<script>
  function validate(){
    var error=false;
    if(document.frm.name.value=="" && error==false)
    {
      alert("Please enter the name");
      error=true;
      document.frm.name.focus();
    }
    if(document.frm.price.value=="" && error==false)
    {
      alert("Please enter the price");
      error=true;
      document.frm.price.focus();
    }
    if(document.frm.price.value!="" && error==false) 
    {
      error=price_validate();
      if (error==true)
      {
        alert("Invalid Price");
        error=true;
        document.frm.price.focus();
      }
    }

    if(!error) {
      var frm = document.frm;					
      frm.action="product_edit.php";			 
      frm.submit(); 
    }	
  }

  function price_validate() {
    var reg = /^[0-9.]+$/;
    var address = document.frm.price.value;
    if(reg.test(address) == false) {
        return true;
    }
    else
    {
      return false;
    }
  }
</script>
