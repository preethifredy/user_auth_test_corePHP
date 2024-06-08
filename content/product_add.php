
<?php 
  error_reporting(1);
  include "inc/dbutil.php";
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $status='1';
  if (empty($name) || !is_numeric($price)) {
      die("Invalid input");
  }

  $stmt = $conn->prepare("INSERT INTO product (name, price,status) VALUES (?, ?, ?)");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("sdi", $name, $price,$status);
  if ($stmt->execute()) {
      header("Location: products.php");
  } else {
      echo "Error: " . $stmt->error;
  }
  $stmt->close();
  $conn->close();
}

?>
<a href="products.php">List Product</a>
<form action="" method="post" id="frm" name="frm">
    Name: <input type="text" name="name" id="name" required><br>
    Price: <input type="text" name="price" id="price" required><br>
    <input type="button" value="Add Product" onclick="validate()">
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
      frm.action="product_add.php";			 
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
