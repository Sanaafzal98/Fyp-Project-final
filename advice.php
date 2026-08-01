<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elara AI – Smart Skin Advisor</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    /* 🌸 GLOBAL STYLES */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #fff1f6 0%, #ffdee9 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* 🎀 CONTAINER CARD */
    .container {
        max-width: 600px;
        width: 100%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(255, 105, 180, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.6);
        animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h2 {
        text-align: center;
        color: #d63384;
        margin-bottom: 30px;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    /* 🩰 FORM ELEMENTS */
    label {
        font-weight: 600;
        display: block;
        margin-top: 20px;
        color: #8b2c5c;
        font-size: 14px;
        margin-bottom: 8px;
    }

    select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 15px;
        border: 1px solid #f8bbd0;
        background: white;
        font-size: 14px;
        color: #555;
        outline: none;
        transition: 0.3s;
        cursor: pointer;
    }

    select:focus {
        border-color: #ff85b3;
        box-shadow: 0 0 10px rgba(255, 133, 179, 0.2);
    }

    /* 🍬 RADIO GROUP */
    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        background: #fffafa;
        padding: 10px 15px;
        border-radius: 12px;
        border: 1px dashed #f7a1c4;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6b3b56;
        cursor: pointer;
    }

    input[type="radio"] {
        accent-color: #d63384;
        transform: scale(1.1);
    }

    /* 💖 BUTTON */
    button {
        margin-top: 35px;
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ff85b3 0%, #d63384 100%);
        color: #fff;
        border: none;
        border-radius: 18px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(214, 51, 132, 0.3);
    }

    button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(214, 51, 132, 0.4);
        filter: brightness(1.1);
    }

    /* ✨ RESULT AREA */
    .result {
        margin-top: 30px;
        background: #fff0f6;
        padding: 20px;
        border-radius: 20px;
        line-height: 1.7;
        color: #7a2c52;
        font-size: 14px;
        border-left: 6px solid #ff85b3;
        display: none; /* Initially hidden */
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .warning {
        color: #d63384;
        font-weight: bold;
    }
</style>
</head>

<body>

<div class="container">
    <h2>Elara AI – Skin Advisor</h2>

    <label>Skin Concern</label>
    <select id="concern">
        <option value="">Select your main concern</option>
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

    <label>Current Season</label>
    <select id="season">
        <option value="">Which season is it?</option>
        <option>Summer</option>
        <option>Winter</option>
        <option>Monsoon</option>
        <option>Spring</option>
        <option>Autumn</option>
    </select>

    <label>Do you feel skin tight after washing your face?</label>
    <div class="radio-group">
        <label class="radio-option"><input type="radio" name="tight" value="Yes"> Yes</label>
        <label class="radio-option"><input type="radio" name="tight" value="No"> No</label>
    </div>

    <label>Do you spend much time outdoors during the day?</label>
    <div class="radio-group">
        <label class="radio-option"><input type="radio" name="outside" value="Yes"> Yes</label>
        <label class="radio-option"><input type="radio" name="outside" value="No"> No</label>
    </div>

    <button onclick="generateAdvice()">Analyze & Get Advice ✨</button>

    <div class="result" id="result"></div>
</div>

<script>
function generateAdvice() {
    const concern = document.getElementById("concern").value;
    const season = document.getElementById("season").value;
    const tight = document.querySelector('input[name="tight"]:checked')?.value;
    const outside = document.querySelector('input[name="outside"]:checked')?.value;
    const resultDiv = document.getElementById("result");

    if (!concern || !season || !tight || !outside) {
        resultDiv.style.display = "block";
        resultDiv.innerHTML = "<span class='warning'>⚠️ Please select all options so Elara can help you properly.</span>";
        return;
    }

    let advice = "<strong>🌸 Your Skin Analysis:</strong><br><br>";

    // Base Concern Logic
    if (concern === "Acne") {
        advice += "Acne happens when pores get clogged. A gentle routine is better than harsh scrubbing. ";
    } else if (concern === "Dry Patches" || concern === "Dehydrated Skin") {
        advice += "Your skin is thirsty! Focus on locking in moisture and repairing your barrier. ";
    } else if (concern === "Oily Skin") {
        advice += "Excess oil needs balancing, not stripping. Hydrated oily skin actually produces less oil. ";
    } else if (concern === "Dark Circles" || concern === "Puffy Eyes") {
        advice += "The eye area is delicate; prioritize rest and cooling hydration. ";
    } else if (concern === "Hyperpigmentation" || concern === "Uneven Complexion") {
        advice += "Uneven tone needs patience and strict sun protection to fade. ";
    } else {
        advice += "Addressing your specific concern with consistent care will show results. ";
    }

    // Season Logic
    advice += `<br><br><strong>Current Season (${season}):</strong> `;
    if (season === "Summer") {
        advice += "The heat triggers sweat and oil. Use gel-based products and reapply SPF often. ";
    } else if (season === "Winter") {
        advice += "Cold air is drying. Switch to creamier textures to protect your skin's glow. ";
    } else {
        advice += "Transition weather can be tricky; keep your routine simple and balanced. ";
    }

    // User Question Logic
    advice += "<br><br><strong>Daily Habits:</strong> ";
    if (tight === "Yes") {
        advice += "Post-wash tightness means your cleanser might be too strong for your barrier. ";
    }
    if (outside === "Yes") {
        advice += "Outdoor time means UV exposure is your biggest challenge—SPF is your best friend! ";
    }

    advice += "<br><br><small><em>Note: This is AI-guided advice based on your input. For medical issues, please see a dermatologist.</em></small>";

    resultDiv.style.display = "block";
    resultDiv.innerHTML = advice;
}
</script>

</body>
</html>