<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Daily Skin Coach + Journey Map</title>

<style>
/* 🌷 GLOBAL */
body {
    font-family: 'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #ffe4f1, #fff0f6);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    perspective: 1200px;
    margin: 0;
}

/* 💗 3D CARD */
.card {
    width: 450px;
    background: linear-gradient(145deg, #ffffff, #ffe6f0);
    border-radius: 22px;
    padding: 30px 25px;
    text-align: center;
    box-shadow: 
        0 20px 40px rgba(255, 105, 180, 0.25),
        0 10px 20px rgba(255, 182, 193, 0.2);
    transform-style: preserve-3d;
    animation: float 6s ease-in-out infinite;
    transition: transform 0.4s ease;
}

/* Hover 3D tilt */
.card:hover {
    transform: rotateX(5deg) rotateY(-5deg) scale(1.03);
}

/* 🌸 FLOAT ANIMATION */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0); }
}

/* 💕 TITLE */
h2 {
    color: #d63384;
    margin-bottom: 15px;
    text-shadow: 0 2px 8px rgba(255, 105, 180, 0.3);
}

/* 🌷 DAILY TIP BOX */
.tip {
    margin-top: 10px;
    padding: 20px;
    background: linear-gradient(
        135deg,
        rgba(255, 240, 246, 0.95),
        rgba(255, 255, 255, 0.8)
    );
    border-left: 5px solid #ff69b4;
    border-radius: 14px;
    color: #6f1d46;
    font-size: 16px;
    line-height: 1.6;
    backdrop-filter: blur(10px);
    animation: fadeUp 0.8s ease;
}

/* 🌼 FADE-UP EFFECT */
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* 🌱 SKIN JOURNEY MAP */
.journey {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 25px;
    gap: 15px;
    font-family: 'Segoe UI', sans-serif;
}

.step {
    background: linear-gradient(145deg, #fff0f6, #ffe4f1);
    border-radius: 14px;
    padding: 12px 18px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(255, 105, 180, 0.2);
    transform-style: preserve-3d;
    transition: transform 0.3s ease;
}

.step:hover {
    transform: rotateX(4deg) rotateY(-4deg) scale(1.05);
}

.step .emoji {
    font-size: 24px;
}

.step .title {
    font-weight: 600;
    color: #d63384;
    margin-top: 4px;
}

.step .desc {
    font-size: 12px;
    color: #6f1d46;
    margin-top: 2px;
}

.arrow {
    font-size: 24px;
    color: #ff69b4;
}

/* 💖 FOOT NOTE */
.note {
    margin-top: 20px;
    font-size: 13px;
    color: #8b2c4a;
}
</style>
</head>

<body>

<div class="card">
    <h2>💗 Daily Skin Coach</h2>

    <!-- 🌸 DAILY TIP -->
    <div id="dailyTip" class="tip"></div>

    <!-- 🌱 SKIN JOURNEY MAP -->
    <div class="journey">
        <div class="step">
            <div class="emoji">🌱</div>
            <div class="title">Start</div>
            <div class="desc">Skin issue detected</div>
        </div>
        <div class="arrow">→</div>
        <div class="step">
            <div class="emoji">🌸</div>
            <div class="title">Now</div>
            <div class="desc">Routine started</div>
        </div>
        <div class="arrow">→</div>
        <div class="step">
            <div class="emoji">🌿</div>
            <div class="title">Next</div>
            <div class="desc">Consistency & protection</div>
        </div>
    </div>

    <!-- 💖 FOOT NOTE -->
    <div class="note">
        Gentle guidance for habit building ✨  
        <br>Not medical advice.
    </div>
</div>

<script>
/* 🌷 DAILY MOTIVATIONAL TIPS */
const tips = [
    "Today avoid harsh scrubs and focus on gentle cleansing.",
    "Apply moisturizer on damp skin to lock hydration today.",
    "Your skin loves consistency more than quick fixes.",
    "Drink enough water today — hydration reflects on your skin.",
    "Be gentle with your skin, healing takes time.",
    "Avoid touching your face unnecessarily today.",
    "Rest and good sleep are also part of skincare.",
    "Progress matters more than perfection.",
    "Simple routines often work better than complicated ones.",
    "Your skin does not need punishment, it needs care.",
    "Protect your skin today — future you will thank you.",
    "Kindness to yourself reflects on your skin."
];

/* 🧠 DATE-BASED ROTATION (24 HOURS AUTO CHANGE) */
const today = new Date().toISOString().split('T')[0];
const index = Math.abs(hash(today)) % tips.length;

document.getElementById("dailyTip").innerText = "🌸 " + tips[index];

/* SIMPLE HASH FUNCTION */
function hash(str) {
    let h = 0;
    for (let i = 0; i < str.length; i++) {
        h = ((h << 5) - h) + str.charCodeAt(i);
        h |= 0;
    }
    return h;
}
</script>

</body>
</html>