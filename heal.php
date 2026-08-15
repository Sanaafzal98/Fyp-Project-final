<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Skin Relaxation Therapy</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins', sans-serif;
}

body{
  min-height:100vh;
  background:linear-gradient(135deg,#ffd6e8,#fbc8e4);
  display:flex;
  align-items:center;
  justify-content:center;
}

/* MAIN CONTAINER */
.wrapper{
  width:92%;
  max-width:1100px;
  background:rgba(255,255,255,0.3);
  backdrop-filter:blur(16px);
  border-radius:26px;
  padding:30px;
}

/* HEADER */
h1{
  text-align:center;
  color:#8b2c5c;
  margin-bottom:8px;
}
p{
  text-align:center;
  color:#7a3b5e;
  margin-bottom:30px;
}

/* THERAPY CARDS */
.cards{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:25px;
}

.card{
  background:rgba(255,255,255,0.5);
  border-radius:22px;
  padding:25px;
  cursor:pointer;
  text-align:center;
  transition:0.4s;
}
.card:hover{
  transform:translateY(-8px);
  box-shadow:0 18px 40px rgba(255,120,180,0.3);
}

.icon{
  font-size:42px;
  margin-bottom:15px;
}

.card h3{
  color:#7a2c52;
  margin-bottom:10px;
}
.card span{
  font-size:14px;
  color:#6b3b56;
}

/* THERAPY SCREEN */
.therapy-screen{
  display:none;
  min-height:400px;
  border-radius:22px;
  background:rgba(255,255,255,0.45);
  padding:30px;
}

.back-btn{
  background:none;
  border:none;
  color:#8b2c5c;
  font-size:14px;
  cursor:pointer;
  margin-bottom:20px;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- HOME -->
 <div id="home">
  <h1>Skin Relaxation Therapy</h1>
  <p>Select a gentle therapy for your skin</p>

  <div class="cards">

    <!-- Skin Breathing -->
    <div class="card" onclick="location.href='skin-breathing-therapy.html'">
      <div class="icon">🌸</div>
      <h3>Skin Breathing</h3>
      <span>Calm your skin with slow breathing</span>
    </div>

    <!-- Gentle Touch -->
    <div class="card" onclick="location.href='gentle-touch-therapy.html'">
      <div class="icon">🤍</div>
      <h3>Gentle Touch</h3>
      <span>Heal with soft interaction</span>
    </div>

    <!-- Emotion Color -->
    <div class="card" onclick="location.href='emotion-color-therapy.html'">
      <div class="icon">🌸</div>
      <h3>Emotion Release</h3>
      <span>Let emotions fade into colors</span>
    </div>

  </div>
</div>

  <!-- THERAPY PLACEHOLDERS -->
  <div id="breathing" class="therapy-screen">
    
    <button class="back-btn" onclick="goBack()">← Back</button>
    <h2>Skin Breathing Therapy</h2>
    
  </div>

  <div id="touch" class="therapy-screen">
   
    <button class="back-btn" onclick="goBack()">← Back</button>
    <h2>Gentle Touch Healing</h2>
    
  </div>

  <div id="color" class="therapy-screen">
    <button class="back-btn" onclick="goBack()">← Back</button>
    <h2>Emotion → Color Release</h2>
  </div>

</div>

<script>
function openTherapy(id){
  document.getElementById('home').style.display='none';
  document.querySelectorAll('.therapy-screen').forEach(s=>s.style.display='none');
  document.getElementById(id).style.display='block';
}

function goBack(){
  document.querySelectorAll('.therapy-screen').forEach(s=>s.style.display='none');
  document.getElementById('home').style.display='block';
}
</script>

</body>
</html>
</html>