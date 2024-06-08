
<?php 
  error_reporting(1);
  include "inc/dbutil.php";
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status='1';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (username, email, password,role,status) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssss", $username, $email, $hashed_password,$role,$status);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

?>
<a href="login.php">Login</a>
<form action="" method="post" id="frm" name="frm">
    Username: <input type="text" name="username" id="username" required><br>
    Email: <input type="email" name="email" id="email" required><br>
    Role: <select name="role" id="role">
            <option value="1">Admin</option>
            <option value="2">User</option>            
        </select><br>
    Password: <input type="password" name="password" id="password" required><br>
    Confirm Password: <input type="password" name="c_password"  id="c_password" required><br>
    <input type="button" name="register" value="Register" onclick="validate()">
</form>

<script>
  function validate(){
    var error=false;
    if(document.frm.username.value=="" && error==false)
    {
      alert("Please enter the username");
      error=true;
      document.frm.username.focus();
    }
    if(document.frm.email.value=="" && error==false)
    {
      alert("Please enter the email");
      error=true;
      document.frm.email.focus();
    }
    if(document.frm.email.value!="" && error==false) 
    {
      error=email_validate();
      if (error==true)
      {
        alert("Invalid email");
        error=true;
        document.frm.email.focus();
      }
    }
    if(document.frm.password.value=="" && error==false)
    {
      alert("Please enter the password");
      error=true;
      document.frm.password.focus();
    }
    if(document.frm.c_password.value=="" && error==false)
    {
      alert("Please enter the confirm password");
      error=true;
      document.frm.c_password.focus();
    }
    if(document.frm.password.value!=document.frm.c_password.value && error==false)
    {
      alert("Incorrect Password");
      error=true;
      document.frm.password.focus();
    }

    if(!error) {
      var frm = document.frm;					
      frm.action="registration_form.php";			 
      frm.submit(); 
    }	
  }

  function email_validate() {
    var reg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var address = document.frm.email.value;
    if(reg.test(address) == false) {
        return true;
    }
    else
    {
      return false;
    }
  }
</script>
