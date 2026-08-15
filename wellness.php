<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Emotional Wellness & Trend Safety</title>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #fff0f6;
        padding: 30px;
    }

    .card {
        max-width: 700px;
        margin: auto;
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(255, 105, 180, 0.15);
    }

    h2 {
        color: #d63384;
        text-align: center;
    }

    .question {
        margin-top: 20px;
    }

    label {
        font-weight: 600;
        color: #6f1d46;
    }

    select {
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        border-radius: 10px;
        border: 1px solid #f3a6c8;
    }

    button {
        margin-top: 25px;
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #ff85b3, #ff4d94);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.9;
    }

    .output {
        margin-top: 25px;
        background: #fff5fa;
        border-left: 5px solid #ff69b4;
        padding: 18px;
        border-radius: 10px;
        color: #6f1d46;
    }

    .trend {
        margin-top: 30px;
        background: #ffe6f0;
        padding: 18px;
        border-radius: 12px;
    }

    .trend h3 {
        color: #c9184a;
    }

    .note {
        font-size: 13px;
        margin-top: 10px;
        color: #8b2c4a;
    
    
    }
</style>
</head>

<body>

<div class="card">

<h2>💗 Emotional Wellness Check</h2>

<div class="question">
<label>Do you feel stressed recently?</label>
<select id="stress">
    <option value="">Select</option>
    <option value="Yes">Yes</option>
    <option value="No">No</option>
</select>
</div>

<div class="question">
<label>How is your mood today?</label>
<select id="mood">
    <option value="">Select</option>
    <option value="Good">😊 Good</option>
    <option value="Neutral">😐 Neutral</option>
    <option value="Low">😔 Low</option>
</select>
</div>

<div class="question">
<label>Do you go outside more these days?</label>
<select id="outside">
    <option value="">Select</option>
    <option value="Yes">Yes</option>
    <option value="No">No</option>
</select>
</div>

<button onclick="showMotivation()">Get Gentle Guidance</button>

<div id="result" class="output"></div>

<!-- Trend Filter Section -->
<div class="trend">
<h3>🛑 Trend Filter (Educational Purpose)</h3>
<ul>
<li>❌ Lemon on face – may cause irritation</li>
<li>❌ Toothpaste on acne – damages skin barrier</li>
<li>❌ Baking soda scrubs – too harsh for skin</li>
<li>✔ Gentle cleansing – safe & recommended</li>
<li>✔ Daily sunscreen – dermatologist approved</li>
</ul>

<p class="note">
This section is for educational awareness only and does not replace professional advice.
</p>
</div>

</div>

<script>
function showMotivation() {
    const stress = document.getElementById("stress").value;
    const mood = document.getElementById("mood").value;
    const outside = document.getElementById("outside").value;

    if (!stress || !mood || !outside) {
        document.getElementById("result").innerHTML =
        "🌸 Please answer all questions for gentle guidance.";
        return;
    }

    let text = "";

    if (stress === "Yes") {
        text += "Stress can sometimes trigger breakouts. Take a deep breath and be gentle with your skin.<br><br>";
    }

    if (mood === "Low") {
        text += "💖 Acne is common and temporary. You are not alone.<br>";
        text += "💖 Your skin does not define your worth.<br><br>";
    }

    if (mood === "Neutral") {
        text += "🌿 Progress matters more than perfection. Stay consistent.<br><br>";
    }

    if (mood === "Good") {
        text += "✨ Your positive mood supports healthy skin. Keep it up!<br><br>";
    }

    text += "<strong>Gentle reminders:</strong><br>";
    text += "• Did you drink enough water today?<br>";
    text += "• Have you been sleeping well this week?<br>";
    text += "• Are you being kind to your skin?<br><br>";

    text += "<em>This guidance is supportive and wellness-focused, not medical advice.</em>";

    document.getElementById("result").innerHTML = text;
}
</script>

</body>
</html>