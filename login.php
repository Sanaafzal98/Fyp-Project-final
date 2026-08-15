<?php
// ===== PHP LOGIN LOGIC =====
session_start();

$conn = mysqli_connect("localhost","root","","auth_system");

$message = "";

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if($email != "" && $password != ""){
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);

            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Incorrect password!";
            }
        } else {
            $message = "Email not registered!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Login</title>

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
.link{
    text-align:center;
    margin-top:10px;
}
.link a{
    color:#ff4d6d;
    text-decoration:none;
    font-size:14px;
}
</style>
</head>

<body>

<div class="container">
    <h2>User Login</h2>

    <form method="POST" onsubmit="return validateLogin()">
        <input type="email" id="email" name="email" placeholder="Email Address">
        <input type="password" id="password" name="password" placeholder="Password">
        <button type="submit" name="login">Login</button>
    </form>

    <div class="msg"><?php echo $message; ?></div>

    <div class="link">
        <a href="register.php">Don't have an account? Register</a>
    </div>
</div>

<!-- ===== JAVASCRIPT ===== -->
<script>
function validateLogin(){
    let email = document.getElementById("email").value.trim();
    let pass = document.getElementById("password").value;

    if(email=="" || pass==""){
        alert("Both fields are required");
        return false;
    }
    return true;
}
</script>

</body>
</html>
