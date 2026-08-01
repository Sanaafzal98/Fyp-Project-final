<?php
/*************************************************
 * ELARA AI DASHBOARD
 * Phase 1 of 3
 * Author: Sana Afzal
 * Purpose: Clean Layout + Session + Base Structure
 *************************************************/

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_name = $_SESSION['user_name'];
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_name = $_SESSION['user_name'];

/* ===== DEMO DATA (Later fetch from DB) ===== */
$ai_results = [
    ["date"=>"2026-01-01","result"=>"No Skin Issue"],
    ["date"=>"2026-01-03","result"=>"Acne Detected"],
    ["date"=>"2026-01-05","result"=>"Mild Redness"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elara AI Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* ================= RESET ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* ================= BODY ================= */
body{
    min-height:100vh;
    background:linear-gradient(135deg,#ffafbd,#ffc3d0);
}

/* ================= PAGE WRAPPER ================= */
.page-wrapper{
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

/* ================= MAIN ================= */
main{
    flex:1;
    display:flex;
    justify-content:center;
    padding:30px 15px;
}

/* ================= DASHBOARD ================= */
.dashboard{
    width:100%;
    max-width:1200px;
    background:#ffffff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    display:flex;
    flex-direction:column;
    gap:25px;
}

/* ================= HEADER ================= */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #ffb6c1;
    padding-bottom:15px;
}

.header h2{
    color:#ff4d6d;
    font-size:22px;
}

.logout-btn{
    background:#ff4d6d;
    color:#fff;
    padding:10px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.logout-btn:hover{
    background:#e63b5f;
}

/* ================= NAV CARDS ================= */
.nav-cards{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.card{
    flex:1 1 220px;
    background:#ffe6f0;
    padding:20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    color:#ff4d6d;
    margin-bottom:10px;
}

.card p{
    font-size:14px;
    color:#333;
}

/* ================= FOOTER ================= */
footer{
    text-align:center;
    padding:20px 10px;
    font-size:14px;
    color:#ff4d6d;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .nav-cards{
        flex-direction:column;
    }
}

/* ===== GLOBAL ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#ffafbd,#ffc3d0);
}

.page-wrapper{
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

main{
    flex:1;
    display:flex;
    justify-content:center;
    padding:30px 15px;
}

.dashboard{
    width:100%;
    max-width:1200px;
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    display:flex;
    flex-direction:column;
    gap:25px;
}

/* ===== HEADER ===== */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #ffb6c1;
    padding-bottom:15px;
}

.header h2{
    color:#ff4d6d;
    font-size:22px;
}

.logout-btn{
    background:#ff4d6d;
    color:#fff;
    padding:10px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.logout-btn:hover{
    background:#e63b5f;
}

/* ===== FLEX SECTION ===== */
.flex-section{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

/* ===== FORM CARDS ===== */
.form-card{
    flex:1 1 320px;
    background:#fff0f5;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.form-card h3{
    color:#ff4d6d;
    margin-bottom:15px;
}

form{
    display:flex;
    flex-direction:column;
    gap:15px;
}

input{
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
}

input:focus{
    outline:none;
    border-color:#ff4d6d;
}

.submit-btn{
    padding:12px;
    background:#ff4d6d;
    color:white;
    border:none;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
}

.submit-btn:hover{
    background:#e63b5f;
}

/* ===== AI RESULT CARD ===== */
.result-card{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    text-align:center;
}

/* ===== HISTORY TABLE ===== */
.history-table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.history-table th{
    background:#ff4d6d;
    color:#fff;
    padding:10px;
}

.history-table td{
    padding:10px;
    border:1px solid #ffc0cb;
    text-align:center;
}

/* ===== FOOTER ===== */
footer{
    text-align:center;
    padding:20px;
    color:#ff4d6d;
}
/* Container / Body styles */
body {
    font-family: Arial, sans-serif;
    background: #f2f4f7;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 50px 20px;
}

/* Form styling */
#uploadForm {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    gap: 15px;
    max-width: 400px;
    width: 100%;
}

/* File input styling */
#uploadForm input[type="file"] {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    width: 100%;
    cursor: pointer;
}

/* Button styling */
#uploadForm button {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    background: #4f46e5;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

#uploadForm button:hover {
    background: #4338ca;
}

/* Status styling */
#uploadStatus {
    margin-top: 20px;
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Result box styling */
#aiResult {
    margin-top: 15px;
    padding: 15px;
    background: #e0e7ff;
    border-radius: 8px;
    min-height: 40px;
    width: 100%;
    text-align: center;
    font-weight: bold;
    color: #1e3a8a;
}

/* Spinner */
.spinner {
    width: 18px;
    height: 18px;
    border: 3px solid #ddd;
    border-top: 3px solid #4f46e5;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    display: inline-block;
    margin-left: 5px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .flex-section{
        flex-direction:column;
    }
}
.flower-bg {
    position: fixed;
    top: 20px; left: 20px;
    font-size: 2rem;
    opacity: 0.1;
    pointer-events: none;
    animation: floatFlowers 10s linear infinite;
}
.elara-affirmation{
    margin-top:15px;
    text-align:center;
    font-size:14px;
    color:#d81b60;
    background:#fff0f5;
    padding:10px 18px;
    border-radius:20px;
    display:inline-block;
    box-shadow:0 4px 10px rgba(216,27,96,0.15);
}


<!-- ================= OPTIONAL STYLING & FINAL TOUCHES ================= -->
/* Highlight latest AI result */
#aiResult {
    font-weight: 600;
    color: #ff4d6d;
}

/* Add hover effect for history table rows */
.history-table tr:hover {
    background-color: #ffe6f0;
}
.elara-signature{
    position:relative;
    max-width:260px;
    padding:20px;
    background:linear-gradient(135deg,#ffe6f0,#fff);
    border-radius:25px;
    box-shadow:0 10px 25px rgba(216,27,96,0.2);
    margin-top:25px;
    font-family:'Segoe UI', sans-serif;
}

.elara-signature.right{
    margin-left:auto;
    text-align:right;
}

/* flower icon circle */
.flower-circle{
    width:48px;
    height:48px;
    background:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    box-shadow:0 4px 10px rgba(216,27,96,0.2);
    position:absolute;
    top:-20px;
    right:20px;
}

/* text */
.elara-signature h4{
    margin-top:25px;
    margin-bottom:8px;
    color:#d81b60;
    font-size:16px;
    font-weight:600;
}

.elara-signature p{
    font-size:13px;
    color:#555;
    line-height:1.5;
}


@keyframes floatFlowers {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-50px) translateX(30px); }
    100% { transform: translateY(0) translateX(0); }
}

</style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Video Fix</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI', sans-serif;
        }

        body{
            background: linear-gradient(135deg, #ffe4ec, #ffd1dc);
            padding:20px;
        }

        .dashboard{
            max-width:1200px;
            margin:auto;
            background:#fff0f6;
            border-radius:16px;
            padding:20px;
            box-shadow:0 10px 30px rgba(255,105,180,0.25);
        }

        .video-container{
    position:relative;
    width:100%;
    aspect-ratio: 26 / 12;   /* PPT jaisa size */
    border-radius:14px;
    overflow:hidden;
    border:3px solid #ff8fb1;
}
        

        video{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .overlay{
            position:absolute;
            inset:0;
            background:rgba(255,182,193,0.35);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .overlay h1{
            color:#fff;
            background:rgba(255,105,180,0.6);
            padding:14px 30px;
            border-radius:30px;
            font-size:34px;
        }
    </style>
</head>
<body>

<div class="dashboard">

    <div class="video-container">
        <video id="introVideo" muted loop playsinline>
            <source src="intro.mp4" type="video/mp4">
        </video>

        <div class="overlay">

        </div>
    </div>

</div>

<script>
    const video = document.getElementById("introVideo");

    // Force play (browser autoplay fix)
    window.addEventListener("load", () => {
        video.play().catch(() => {
            console.log("Autoplay blocked, retrying...");
        });
    });

    // Extra safety: restart if paused
    video.addEventListener("ended", () => {
        video.currentTime = 0;
        video.play();
    });
</script>

</body>
</html>
<body>



    
<div class="page-wrapper">

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elara AI – Dashboard</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* BODY */
body{
    background:linear-gradient(135deg,#ffe6f0,#fff5fa);
    font-family:'Poppins', sans-serif;
    color:#444;
}

/* MAIN */
main{
    padding:30px;
}

/* DASHBOARD */
.dashboard{
    max-width:1200px;
    margin:auto;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:rgba(255,255,255,0.9);
    padding:20px 25px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(255,182,193,0.35);
    margin-bottom:30px;
}

.header h2{
    font-family:'Playfair Display', serif;
    font-weight:600;
    color:#c2185b;
}

.logout-btn{
    text-decoration:none;
    background:#f48fb1;
    color:white;
    padding:8px 18px;
    border-radius:25px;
    font-size:14px;
    transition:0.3s;
}
.logout-btn:hover{
    background:#ec407a;
}

/* NAV CARDS */
.nav-cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:22px;
    margin-bottom:40px;
}

.card{
    background:white;
    padding:22px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(255,182,193,0.35);
    transition:0.4s ease;
}

.card:hover{
    transform:translateY(-8px);
}

.card h3{
    font-family:'Playfair Display', serif;
    color:#ad1457;
    margin-bottom:10px;
}

.card p{
    font-size:14px;
    line-height:1.6;
    color:#666;
}

/* FLOWER BG */
.flower-bg{
    text-align:center;
    font-size:26px;
    opacity:0.4;
    margin-bottom:35px;
}

/* ELARA BOX */
.elara-box{
    background:rgba(255,255,255,0.92);
    padding:35px;
    border-radius:25px;
    box-shadow:0 18px 35px rgba(255,182,193,0.4);
    text-align:center;
}

/* SIGNATURE */
.elara-signature{
    margin-bottom:20px;
}

.flower-circle{
    width:55px;
    height:55px;
    margin:auto;
    border-radius:50%;
    background:#ffe0ec;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    box-shadow:0 6px 15px rgba(255,182,193,0.4);
}

.elara-signature h4{
    font-family:'Playfair Display', serif;
    color:#c2185b;
    margin-top:10px;
}

.elara-signature p{
    font-size:13px;
    color:#777;
    line-height:1.5;
}

/* ELARA TEXT */
.elara-box h2{
    font-family:'Playfair Display', serif;
    color:#ad1457;
    margin:20px 0;
}

.elara-box p{
    font-size:15px;
    line-height:1.8;
    color:#555;
    margin-bottom:15px;
}

/* AFFIRMATION */
.elara-affirmation{
    margin-top:30px;
    text-align:center;
    font-family:'Playfair Display', serif;
    font-size:18px;
    color:#b71c5c;
}
</style>
</head>

<body>

<main>
<div class="dashboard">

    <!-- HEADER -->
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?> 🌸</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- NAVIGATION CARDS -->
    <div class="nav-cards">
        <div class="card">
            <h3>Upload Image</h3>
            <p>Upload your face image for AI skin analysis</p>
                <p>Upload a clear face image for gentle AI skin analysis 🌸</p>

        </div>

        <div class="card">
            <h3>Lifestyle Details</h3>
            <p>Share sleep, water intake & age</p>
            <p>Share your routine to improve hydration, rest, and glow 💧🌷</p>
        </div>

        <div class="card">
            <h3>AI Results</h3>
            <p>View personalized skin insights</p>
            
        </div>
    </div>

    <div class="flower-bg">🌸 🌸 🌸</div>

    <!-- ELARA INTRO -->
    <div class="elara-box">

        <div class="elara-signature">
            <div class="flower-circle">🌸</div>
            <h4>Elara Moment</h4>
            <p>Your skin is learning, healing,<br>and glowing — beautifully.</p>
        </div>

        <h2>Elara AI – The Smart Glow 🌸</h2>

        <p>
            Elara AI – The Smart Glow is your intelligent skincare companion.
            Using advanced AI, it analyzes your skin and provides personalized
            care suggestions designed just for you.
        </p>

        <p>
            With every check, Elara gently guides your skin toward health and
            confidence — just like soft pink petals 🌸 unfolding with care.
            Experience skincare where science meets elegance.
        </p>

    </div>

    <div class="elara-affirmation">
        ✨ You are glowing — and Elara knows it 🌷
    </div>

</div>
</main>

</body>
</html>


        <!-- USER INPUT SECTION -->
        <section class="flex-section">

            <!-- IMAGE UPLOAD -->
             <form id="uploadForm">
             <input type="file" id="skinImage" accept="image/*">
             <button onclick="analyzeSkin()">Analyze Skin</button>

                <div id="result"></div>


               <div id="uploadStatus"></div>
            <div id="aiResult"></div>
              </form>
              
            <!-- ELARA POLL -->
            <!-- ================= ELARA INTERACTIVE PANEL ================= -->


        </section>
        <!-- ================= AI RESULT ================= -->
       
        <!-- ================= HISTORY ================= -->
         
        

    </div>
</main>

</div>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elara AI Cards</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background: linear-gradient(135deg, #ffe4ec, #ffd1dc);
    padding:30px;
}

/* ---------- CONTAINER ---------- */
.cards-container{
    max-width:1300px;
    margin:auto;
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap:35px;
}

/* ---------- CARD ---------- */
.card{
    height:300px;                /* BIG SIZE */
    background: linear-gradient(135deg, #ffd6e8, #fff5fa);
    border-radius:26px;
    padding:30px;
    cursor:pointer;
    position:relative;
    box-shadow:0 18px 45px rgba(255,20,147,0.3);
    transition: transform 0.6s ease, box-shadow 0.6s ease;
    transform-style: preserve-3d;
}

/* 3D hover */
.card:hover{
    transform: rotateY(14deg) rotateX(8deg) scale(1.07);
    box-shadow:0 30px 65px rgba(255,20,147,0.5);
}

/* ---------- ICON ---------- */
.icon{
    width:70px;
    height:70px;
    border-radius:50%;
    background:#ff8fb1;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    color:white;
    margin-bottom:22px;
    box-shadow:0 10px 25px rgba(255,20,147,0.4);
}

/* ---------- TEXT ---------- */
.card h3{
    color:#b03060;
    font-size:24px;
    margin-bottom:14px;
}

.card p{
    color:#7a1f3d;
    font-size:15px;
    line-height:1.7;
}

.card span{
    position:absolute;
    bottom:26px;
    left:30px;
    color:#ff4d88;
    font-weight:600;
    font-size:15px;
}
</style>
</head>

<body>

<div class="cards-container">

    <div class="card" onclick="location.href='wellness.php'">
        <div class="icon">💗</div>
        <h3>Emotional Wellness Check</h3>
        <p>
            Feeling stressed or emotionally tired?
            Elara gently checks your emotions
            and motivates your heart.
        </p>
        <span>For more information →</span>
    </div>

    <div class="card" onclick="location.href='heal.php'">
        <div class="icon">🌸</div>
        <h3>Healing Therapy</h3>
        <p>
            If you feel low or overwhelmed,
            take this calming therapy
            designed for inner peace.
        </p>
        <span>Start healing →</span>
    </div>

    <div class="card" onclick="location.href='aging.php'">
        <div class="icon">🔮</div>
        <h3>Future You (5 Years)</h3>
        <p>
            See how confident and glowing
            you can look in 5 years
            by following self-care.
        </p>
        <span>See your future →</span>
    </div>

    <div class="card" onclick="location.href='advice.php'">
        <div class="icon">🌷</div>
        <h3>Daily Gentle Advice</h3>
        <p>
            Soft advice and emotional guidance
            to support your mental
            and emotional wellness.
        </p>
        <span>Get advice →</span>
    </div>

        <div class="card" onclick="location.href='Today’s Gentle Message.html'">
        <div class="icon">🌷</div>
        <h3>Today Gentle Message</h3>
        <p>
            Soft advice and emotional checkup
            to support your mental
            and emotional wellness.
        </p>
        <span>Get advice →</span>
    </div>

</div>

</body>
</html>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const uploadForm = document.getElementById("uploadForm");
    const fileInput = document.getElementById("skinImage"); // match your input id
    const statusEl = document.getElementById("uploadStatus");
    const resultEl = document.getElementById("result"); // match showResults div

    uploadForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        if (!fileInput.files.length) {
            alert("Please select an image!");
            return;
        }

        const file = fileInput.files[0];
        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedTypes.includes(file.type)) {
            alert("Only JPG or PNG images are allowed!");
            return;
        }

        statusEl.innerHTML = "Analyzing your skin... 🔍 <span class='spinner'></span>";
        resultEl.innerHTML = "";

        const formData = new FormData();
        formData.append("file", file); // FastAPI key = "file"

        try {
            // FastAPI server url
            const response = await fetch("http://127.0.0.1:8000/predict", {
                method: "POST",
                body: formData
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Server error: ${errorText}`);
            }

            const data = await response.json();

            // UX Delay
            setTimeout(() => {
                showResults(data);
                statusEl.innerText = "Analysis Complete ✅";
            }, 500);

        } catch (error) {
            console.error("Prediction error:", error);
            statusEl.innerText = "Error analyzing image ❌";
            resultEl.innerHTML = `<div class="error-msg">${error.message}</div>`;
        }
    });
});

function showResults(data) {
    const resultDiv = document.getElementById("result");
    
    // Agar FastAPI response successful hai toh output show karein
    if (data.success) {
        const rec = data.recommendations;
        
        resultDiv.innerHTML = `
            <div class="analysis-card">
                <h3>Detected Condition: <span class="highlight">${data.condition}</span></h3>
                <h4>Confidence: ${data.confidence}%</h4>
                <hr>
                <p><b>Home Remedies:</b> ${rec.home_remedies}</p>
                <p><b>Key Ingredients:</b> ${rec.ingredients}</p>
                <p><b>Product Suggestions:</b> ${rec.products}</p>
                <p><b>What to Do:</b> ${rec.do}</p>
                <p><b>What to Avoid:</b> ${rec.avoid}</p>
                <p><b>Lifestyle Tips:</b> ${rec.lifestyle}</p>
                <p><b>Sleep | Water Habits:</b> Sleep: ${rec.sleep} | Water: ${rec.water}</p>
            </div>
        `;
    } else {
        resultDiv.innerHTML = `<div class="error-msg">API Error: ${data.error}</div>`;
    }
}
</script>
