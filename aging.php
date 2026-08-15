<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elara AI – Skin Aging Predictor</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
/* 🌸 GLOBAL STYLES */
body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #ffe6f0, #fff1f7);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

/* 🎀 MAIN LAYOUT CONTAINER */
.container {
    display: flex;
    flex-direction: row;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(15px);
    border-radius: 30px;
    width: 90%;
    max-width: 950px;
    box-shadow: 0 25px 50px rgba(255, 105, 180, 0.15);
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.5);
    animation: fadeUp 0.8s ease;
}

/* 🧪 LEFT SIDE: INPUTS */
.sidebar {
    flex: 1;
    padding: 40px;
    background: white;
    border-right: 1px solid #fce4ec;
}

/* 📊 RIGHT SIDE: RESULTS */
.main-content {
    flex: 1.2;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: rgba(255, 245, 250, 0.5);
}

h2, h3 {
    color: #d63384;
    margin-bottom: 20px;
    font-weight: 600;
}

/* 🎀 FORM ELEMENTS */
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 12px;
    border: 1px solid #f8bbd0;
    background: #fff;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

select:focus {
    border-color: #ff85b3;
    box-shadow: 0 0 8px rgba(255, 133, 179, 0.2);
}

button {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #ff85b3, #ff5fa2);
    color: white;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(255, 105, 180, 0.3);
    transition: 0.3s;
    margin-bottom: 10px;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(255, 105, 180, 0.4);
}

/* 📊 CHART & TEXT */
#agingChart {
    max-height: 250px;
    margin-bottom: 20px;
}

#agingText {
    padding: 15px;
    border-radius: 15px;
    background: white;
    color: #8b1c4a;
    font-size: 14px;
    line-height: 1.5;
    border-left: 5px solid #ff85b3;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}

.simulator-box {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px dashed #f7a1c4;
}

.sim-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

#whatIfResult {
    margin-top: 15px;
    font-size: 13px;
    color: #a61c5c;
    font-style: italic;
}

/* ✨ ANIMATION */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .container { flex-direction: column; width: 95%; }
    .sidebar, .main-content { padding: 25px; }
}
</style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>Elara AI</h2>
        <p style="font-size: 12px; color: #888; margin-bottom: 20px;">Personalized Skin Aging Analysis</p>
        
        <select id="label">
            <option value="">Select Skin Concern</option>
            <option>Acne</option>
            <option>Cystic Acne</option>
            <option>Acne Scars</option>
            <option>Redness</option>
            <option>Dry Patches</option>
            <option>Dehydrated Skin</option>
            <option>Oily Skin</option>
            <option>Enlarged Pores</option>
            <option>Dark Circles</option>
            <option>Puffy Eyes</option>
            <option>Wrinkles</option>
            <option>Hyperpigmentation</option>
            <option>Uneven Complexion</option>
        </select>

        <select id="hydration">
            <option value="">Hydration Level</option>
            <option value="good">Good</option>
            <option value="avg">Average</option>
            <option value="poor">Low</option>
        </select>

        <select id="sleep">
            <option value="">Sleep Quality</option>
            <option value="good">Good</option>
            <option value="avg">Average</option>
            <option value="poor">Poor</option>
        </select>

        <select id="sunscreen">
            <option value="">Use Sunscreen?</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <select id="sunExposure">
            <option value="">Daily Sun Exposure</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>

        <select id="diet">
            <option value="">Diet Quality</option>
            <option value="good">Healthy</option>
            <option value="avg">Balanced</option>
            <option value="poor">Unhealthy</option>
        </select>

        <button onclick="predictAging()">Analyze My Skin</button>
    </div>

    <div class="main-content">
        <h3>Analysis Results</h3>
        <canvas id="agingChart"></canvas>
        <div id="agingText">Select your habits and click analyze to see results.</div>

        <div class="simulator-box">
            <h4 style="color: #d63384; font-size: 15px; margin-bottom: 10px;">🧪 What-If Simulator</h4>
            <div class="sim-buttons">
                <button style="font-size: 11px; padding: 10px;" onclick="whatIf('sunscreen')">Skip Sunscreen?</button>
                <button style="font-size: 11px; padding: 10px;" onclick="whatIf('sleep')">Improve Sleep?</button>
                <button style="font-size: 11px; padding: 10px; grid-column: span 2;" onclick="whatIf('sun')">More Sun Exposure?</button>
            </div>
            <div id="whatIfResult"></div>
        </div>
    </div>
</div>

<script>
let chart;

function score(value){
    if(value === "good") return 25;
    if(value === "avg") return 15;
    return 5;
}

function sunScore(value){
    if(value === "low") return 25;
    if(value === "medium") return 15;
    return 5;
}

function predictAging(){
    const hydration = score(document.getElementById("hydration").value);
    const sleep = score(document.getElementById("sleep").value);
    const diet = score(document.getElementById("diet").value);
    const sunscreen = document.getElementById("sunscreen").value === "yes" ? 25 : 0;
    const sun = sunScore(document.getElementById("sunExposure").value);

    const total = hydration + sleep + diet + sunscreen + sun;

    let level = "";
    let message = "";

    if(total >= 100){
        level = "Healthy Aging";
        message = "🌸 Your routine strongly supports healthy skin aging. Keep protecting your skin consistently.";
    } 
    else if(total >= 70){
        level = "Moderate Aging";
        message = "🌿 Your skin is stable, but improving sun protection and habits can slow aging.";
    } 
    else {
        level = "Early Aging Risk";
        message = "⚠️ High sun exposure and lifestyle gaps may accelerate skin aging. Gentle improvements can help.";
    }

    document.getElementById("agingText").innerHTML = `<strong>${level}:</strong> ${message}`;

    if(chart) chart.destroy();
    chart = new Chart(document.getElementById("agingChart"), {
        type: "bar",
        data: {
            labels: ["Skin Aging Score"],
            datasets: [{
                label: "Points",
                data: [total],
                backgroundColor: "#f7a1c4",
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { max: 125, display: false },
                x: { display: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
}

function whatIf(type){
    let result = "";
    if(type === "sunscreen") result = "☀️ Skipping sunscreen can increase UV damage, pigmentation, and early wrinkles.";
    if(type === "sleep") result = "😴 Better sleep improves skin repair, glow, and reduces puffiness.";
    if(type === "sun") result = "🌞 Increased sun exposure without protection may speed up skin aging and dark spots.";
    
    document.getElementById("whatIfResult").innerHTML = result;
}
</script>

</body>
</html>