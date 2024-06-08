
<?php 
  error_reporting(1);
  include "inc/dbutil.php";
  session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username_email = $_POST['username_email'];
  $password = $_POST['password'];
  
  $stmt = $conn->prepare("SELECT id, username, email, password,role FROM user WHERE username=? OR email=?");
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("ss", $username_email, $username_email);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($id, $username, $email, $hashed_password,$role);
  $stmt->fetch();

  if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['role'] = $role;
      header("Location: dashboard.php");
  } else {
      echo "Invalid credentials!";
  }
  $stmt->close();
  $conn->close();
}

?>
<a href="registration_form.php">Register</a>
<form action="" method="post" id="frm" name="frm">
        Username/Email: <input type="text" name="username_email" id="username_email" required><br>
        Password: <input type="password" name="password" id="password" required><br>
        <input type="button" name="login" value="Login" onclick="validate()">
    </form>

<script>
  function validate(){
    var error=false;
    if(document.frm.username_email.value=="" && error==false)
    {
      alert("Please enter the username/email");
      error=true;
      document.frm.username_email.focus();
    }
    if(document.frm.password.value=="" && error==false)
    {
      alert("Please enter the password");
      error=true;
      document.frm.password.focus();
    }

    if(!error) {
      var frm = document.frm;					
      frm.action="login.php";			 
      frm.submit(); 
    }	
  }

</script>
