<?php
// ===== PHP REGISTER LOGIC =====
$conn = mysqli_connect("localhost","root","","auth_system");

$message = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // check existing email
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $message = "Email already registered!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users(name,email,password)
                  VALUES('$name','$email','$hash')";
        mysqli_query($conn,$query);
        $message = "Registration successful!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Registration</title>

<!-- ===== CSS ===== -->
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}
body{
    background:linear-gradient(135deg,#ffafbd,#ffc3d0);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.container{
    background:white;
    width:380px;
    padding:30px;
    border-radius:18px;
    box-shadow:0 15px 35px rgba(0,0,0,0.25);
}
.container h2{
    text-align:center;
    color:#ff4d6d;
    margin-bottom:20px;
}
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
    border:1px solid #ddd;
    font-size:15px;
}
input:focus{
    outline:none;
    border-color:#ff4d6d;
}
button{
    width:100%;
    padding:12px;
    background:#ff4d6d;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
}
button:hover{
    background:#e63b5f;
}
.msg{
    text-align:center;
    margin-top:12px;
    font-weight:500;
    color:#ff4d6d;
}
</style>
</head>

<body>

<div class="container">
    <h2>User Registration</h2>

    <form method="POST" onsubmit="return validateForm()">
        <input type="text" id="name" name="name" placeholder="Full Name">
        <input type="email" id="email" name="email" placeholder="Email Address">
        <input type="password" id="password" name="password" placeholder="Password">
        <button type="submit" name="register">Register</button>
    </form>

    <div class="msg"><?php echo $message; ?></div>
</div>

<!-- ===== JAVASCRIPT ===== -->
<script>
function validateForm(){
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let pass = document.getElementById("password").value;

    if(name=="" || email=="" || pass==""){
        alert("All fields are required");
        return false;
    }
    if(pass.length < 6){
        alert("Password must be at least 6 characters");
        return false;
    }
    return true;
}
</script>

</body>
</html>
