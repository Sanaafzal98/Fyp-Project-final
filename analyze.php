<?php
session_start();

/* ================= ANALYZE IMAGE ================= */
if (isset($_POST['analyze'])) {

    // yahan tumhari REAL prediction logic already lagi hui hogi
    // main demo values de rahi hoon

    $_SESSION['analyzed'] = true;
    $_SESSION['issue'] = "Acne Detected";
    $_SESSION['confidence'] = "89%";
    $_SESSION['remedies'] = [
        "Drink more water",
        "Avoid oily food",
        "Use gentle cleanser",
        "Apply aloe vera gel"
    ];
}

/* ================= SECURITY ================= */
$canOpen = isset($_SESSION['analyzed']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Elara AI Dashboard</title>

<style>
body{
  font-family: Poppins, Arial;
  background:#ffe6f0;
  padding:30px;
}
.container{
  max-width:900px;
  margin:auto;
}
.card{
  background:white;
  padding:20px;
  border-radius:14px;
  margin-bottom:20px;
}
.nav-cards{
  display:flex;
  gap:20px;
}
.nav-cards .card{
  flex:1;
  cursor:pointer;
  transition:.3s;
}
.nav-cards .card:hover{
  transform:translateY(-4px);
}
.disabled{
  opacity:.4;
  pointer-events:none;
}
button{
  background:#ff5fa2;
  color:white;
  border:none;
  padding:10px 16px;
  border-radius:8px;
  cursor:pointer;
}
a{
  text-decoration:none;
  color:#ff3f8b;
  font-weight:600;
}
.result-box{
  background:#fff0f6;
  padding:15px;
  border-radius:12px;
}
</style>
</head>

<body>
<div class="container">

<!-- ================= IMAGE ANALYSIS ================= -->
<div class="card">
<h3>Upload Image</h3>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="image" required>
<br><br>
<button name="analyze">Analyze Skin</button>
</form>

<?php if($canOpen): ?>
<p style="color:green;margin-top:10px;">✔ Skin analysis completed</p>
<?php endif; ?>
</div>

<!-- ================= NAVIGATION CARDS ================= -->
<div class="nav-cards">

<div class="card">
<h3>Upload Image</h3>
<p>Upload a clear face image for AI skin analysis 🌸</p>
</div>

<div class="card">
<h3>Lifestyle Details</h3>
<p>Hydration & good sleep help skin heal naturally 💧</p>
</div>

<!-- 🔐 THIRD CARD (LOCKED / UNLOCKED) -->
<div class="card <?php echo !$canOpen ? 'disabled' : ''; ?>">
<h3>AI Results</h3>

<?php if($canOpen): ?>
<a href="#result">Open Results →</a>
<?php else: ?>
<p style="color:#999;">Analyze image to unlock</p>
<?php endif; ?>

</div>

</div>

<!-- ================= RESULT SECTION ================= -->
<?php if($canOpen): ?>
<div class="card" id="result">
<h3>🌸 Elara AI Result</h3>

<div class="result-box">
<p><b>Issue:</b> <?php echo $_SESSION['issue']; ?></p>
<p><b>Confidence:</b> <?php echo $_SESSION['confidence']; ?></p>

<b>Remedies:</b>
<ul>
<?php foreach($_SESSION['remedies'] as $r): ?>
<li><?php echo $r; ?></li>
<?php endforeach; ?>
</ul>

<a href="download.php">Download PDF / PNG</a>
</div>
</div>
<?php endif; ?>

</div>
</body>
</html>