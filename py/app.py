import torch
import torch.nn as nn
import torch.optim as optim
import torch.nn.functional as F
from torchvision import datasets
from torch.utils.data import DataLoader
import clip
import numpy as np
import matplotlib
matplotlib.use('Agg')  
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.metrics import (
    classification_report,
    confusion_matrix,
    roc_curve,
    auc
)
from sklearn.preprocessing import label_binarize
from tqdm import tqdm
import gradio as gr
from PIL import Image
from sentence_transformers import SentenceTransformer
import faiss

# FastAPI imports
from fastapi import FastAPI, File, UploadFile
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
import uvicorn
import threading
import io

# ==========================================
# 1. Configuration & Device
# ==========================================
device = "cuda" if torch.cuda.is_available() else "cpu"
model, preprocess = clip.load("ViT-B/32", device=device, download_root="./clip_cache")
print(f"Using device: {device}")

# ==========================================
# 2. Folder Paths
# ==========================================
train_dir = r"C:\xampp\htdocs\fypproject\dataset\clip\training"
val_dir   = r"C:\xampp\htdocs\fypproject\dataset\clip\validation"
test_dir  = r"C:\xampp\htdocs\fypproject\dataset\clip\testing"

WEAK_CLASSES = [
    'a face with uneven complextion',
    'a face with enlarged pores'
]

# ==========================================
# 3. Dataset Loading
# ==========================================
train_dataset = datasets.ImageFolder(root=train_dir, transform=preprocess)
val_dataset   = datasets.ImageFolder(root=val_dir,   transform=preprocess)
test_dataset  = datasets.ImageFolder(root=test_dir,  transform=preprocess)

class_names = train_dataset.classes
num_classes = len(class_names)

train_loader = DataLoader(train_dataset, batch_size=16, shuffle=True,  num_workers=0)
val_loader   = DataLoader(val_dataset,   batch_size=16, shuffle=False, num_workers=0)
test_loader  = DataLoader(test_dataset,  batch_size=16, shuffle=False, num_workers=0)

print(f"\nClasses     : {class_names}")
print(f"Training    : {len(train_dataset)} images")
print(f"Validation  : {len(val_dataset)} images")
print(f"Testing     : {len(test_dataset)} images\n")

# ==========================================
# 4. SkinCLIPAdapter
# ==========================================
class SkinCLIPAdapter(nn.Module):
    def __init__(self, input_dim, num_classes):
        super(SkinCLIPAdapter, self).__init__()
        self.ln = nn.LayerNorm(input_dim)
        self.bottleneck = nn.Sequential(
            nn.Linear(input_dim, 512),
            nn.BatchNorm1d(512),
            nn.GELU(),
            nn.Dropout(0.5),
            nn.Linear(512, 256),
            nn.BatchNorm1d(256),
            nn.GELU(),
            nn.Dropout(0.5),
            nn.Linear(256, input_dim)
        )
        self.classifier = nn.Linear(input_dim, num_classes)
        self.alpha = nn.Parameter(torch.tensor(0.5))

    def forward(self, x):
        identity = x
        x = self.ln(x)
        x = self.bottleneck(x)
        x = self.alpha * x + (1 - self.alpha) * identity
        return self.classifier(x)

# ==========================================
# 5. Model Setup
# ==========================================
loss_weights = torch.ones(num_classes).to(device)
for i, cls in enumerate(class_names):
    if cls in WEAK_CLASSES:
        loss_weights[i] = 2.0

adapter = SkinCLIPAdapter(512, num_classes).to(device)

criterion = nn.CrossEntropyLoss(weight=loss_weights, label_smoothing=0.1)
optimizer = optim.AdamW(adapter.parameters(), lr=1e-4, weight_decay=3e-2)
scheduler = optim.lr_scheduler.CosineAnnealingLR(optimizer, T_max=50)

# ==========================================
# 6. Training Variables
# ==========================================
epochs       = 30
best_val_acc = 0.0
patience     = 10
no_improve   = 0

train_losses     = []
train_accuracies = []
val_accuracies   = []
test_accuracies  = []

# ==========================================
# ==========================================
# 7. Training Loop & Visualization Execution
# ==========================================
if __name__ == '__main__':
    print("Starting Training...\n")

    for epoch in range(epochs):

        adapter.train()
        total_loss = 0

        for images, labels in tqdm(train_loader, desc=f"Epoch {epoch+1}/{epochs}"):
            images = images.to(device)
            labels = labels.to(device)

            with torch.no_grad():
                features = model.encode_image(images).float()
                features /= features.norm(dim=-1, keepdim=True)

            outputs = adapter(features)
            loss    = criterion(outputs, labels)

            optimizer.zero_grad()
            loss.backward()
            optimizer.step()

            total_loss += loss.item()

        adapter.eval()
        train_correct = val_correct = test_correct = 0

        with torch.no_grad():
            for images, labels in train_loader:
                images, labels = images.to(device), labels.to(device)
                features = model.encode_image(images).float()
                features /= features.norm(dim=-1, keepdim=True)
                _, preds = torch.max(adapter(features), 1)
                train_correct += (preds == labels).sum().item()

            for images, labels in val_loader:
                images, labels = images.to(device), labels.to(device)
                features = model.encode_image(images).float()
                features /= features.norm(dim=-1, keepdim=True)
                _, preds = torch.max(adapter(features), 1)
                val_correct += (preds == labels).sum().item()

            for images, labels in test_loader:
                images, labels = images.to(device), labels.to(device)
                features = model.encode_image(images).float()
                features /= features.norm(dim=-1, keepdim=True)
                _, preds = torch.max(adapter(features), 1)
                test_correct += (preds == labels).sum().item()

        train_acc  = 100 * train_correct / len(train_dataset)
        val_acc    = 100 * val_correct   / len(val_dataset)
        test_acc   = 100 * test_correct  / len(test_dataset)
        epoch_loss = total_loss / len(train_loader)

        train_losses.append(epoch_loss)
        train_accuracies.append(train_acc)
        val_accuracies.append(val_acc)
        test_accuracies.append(test_acc)

        if val_acc > best_val_acc:
            best_val_acc = val_acc
            no_improve   = 0
            torch.save(adapter.state_dict(), "best_skin_model.pth")
            print(f"   Best model saved — Val: {val_acc:.2f}%")
        else:
            no_improve += 1

        scheduler.step()

        print(
            f"Epoch [{epoch+1}/{epochs}] | "
            f"Loss: {epoch_loss:.4f} | "
            f"Train: {train_acc:.2f}% | "
            f"Val: {val_acc:.2f}% | "
            f"Test: {test_acc:.2f}%"
        )

        if no_improve >= patience:
            print(f"\nEarly stopping — Val {patience} epochs mein improve nahi hua.")
            break

    print(f"\nBest Validation Accuracy: {best_val_acc:.2f}%")
    
   
# ==========================================
# 8. Helper — collect predictions
# ==========================================
def collect_predictions(loader):
    all_preds, all_labels, all_probs = [], [], []
    with torch.no_grad():
        for images, labels in loader:
            images = images.to(device)
            features = model.encode_image(images).float()
            features /= features.norm(dim=-1, keepdim=True)
            outputs  = adapter(features)
            probs    = F.softmax(outputs, dim=1)
            _, preds = torch.max(outputs, 1)
            all_preds.extend(preds.cpu().numpy())
            all_labels.extend(labels.numpy())
            all_probs.extend(probs.cpu().numpy())
    return np.array(all_preds), np.array(all_labels), np.array(all_probs)

# ==========================================
# ==========================================
# 9. Visualization
# ==========================================
def plot_results():
    adapter.load_state_dict(torch.load("best_skin_model.pth", map_location=device))
    adapter.eval()

    short_names = [c.replace("a face with ", "") for c in class_names]

    tr_preds, tr_labels, tr_probs = collect_predictions(train_loader)
    vl_preds, vl_labels, vl_probs = collect_predictions(val_loader)
    ts_preds, ts_labels, ts_probs = collect_predictions(test_loader)

    # 1. Loss & Accuracy Curves
    fig1, axes = plt.subplots(1, 2, figsize=(14, 5))
    axes[0].plot(train_losses, marker='o', color='steelblue')
    axes[0].set_title("Training Loss Curve")
    axes[0].set_xlabel("Epoch"); axes[0].set_ylabel("Loss"); axes[0].grid(True)
    axes[1].plot(train_accuracies, label='Train',      color='steelblue')
    axes[1].plot(val_accuracies,   label='Validation', color='orange')
    axes[1].plot(test_accuracies,  label='Test',       color='green')
    axes[1].set_title("Accuracy Curves (Train / Val / Test)")
    axes[1].set_xlabel("Epoch"); axes[1].set_ylabel("Accuracy %")
    axes[1].legend(); axes[1].grid(True)
    plt.tight_layout(); plt.savefig("curves.png", dpi=150); plt.close() # <-- plt.show() hata diya

    # 2. Confusion Matrices
    fig2, axes = plt.subplots(1, 3, figsize=(24, 7))
    for ax, preds, labels, title in zip(axes,
        [tr_preds, vl_preds, ts_preds],
        [tr_labels, vl_labels, ts_labels],
        ["Training", "Validation", "Testing"]):
        cm = confusion_matrix(labels, preds)
        sns.heatmap(cm, annot=True, fmt='d', cmap='Blues',
                    xticklabels=short_names, yticklabels=short_names, ax=ax)
        ax.set_title(f"Confusion Matrix — {title}")
        ax.set_xlabel("Predicted"); ax.set_ylabel("Actual")
    plt.tight_layout(); plt.savefig("confusion_matrices.png", dpi=150); plt.close() # <-- plt.show() hata diya

    # 3. Per-Class Accuracy
    fig3, axes = plt.subplots(1, 3, figsize=(22, 6))
    for ax, preds, labels, title in zip(axes,
        [tr_preds, vl_preds, ts_preds],
        [tr_labels, vl_labels, ts_labels],
        ["Training", "Validation", "Testing"]):
        cm  = confusion_matrix(labels, preds)
        pca = cm.diagonal() / cm.sum(axis=1) * 100
        ax.bar(range(num_classes), pca, color='steelblue')
        ax.set_title(f"Per-Class Accuracy — {title}")
        ax.set_xticks(range(num_classes))
        ax.set_xticklabels(short_names, rotation=45, ha='right')
        ax.set_ylabel("Accuracy %"); ax.set_ylim(0, 110)
    plt.tight_layout(); plt.savefig("per_class_accuracy.png", dpi=150); plt.close() # <-- plt.show() hata diya

    # 4. ROC Curves
    fig4, axes = plt.subplots(1, 3, figsize=(22, 6))
    for ax, probs, labels, title in zip(axes,
        [tr_probs, vl_probs, ts_probs],
        [tr_labels, vl_labels, ts_labels],
        ["Training", "Validation", "Testing"]):
        binary_labels = label_binarize(labels, classes=range(num_classes))
        for i in range(num_classes):
            fpr, tpr, _ = roc_curve(binary_labels[:, i], probs[:, i])
            ax.plot(fpr, tpr, label=f'{short_names[i]} AUC={auc(fpr,tpr):.2f}')
        ax.plot([0,1],[0,1],'--',color='gray')
        ax.set_title(f"ROC Curve — {title}")
        ax.set_xlabel("FPR"); ax.set_ylabel("TPR"); ax.legend(fontsize=7)
    plt.tight_layout(); plt.savefig("roc_curves.png", dpi=150); plt.close() # <-- plt.show() hata diya

    # 5. Classification Reports
    fig5, axes = plt.subplots(1, 3, figsize=(26, 6))
    for ax, preds, labels, title in zip(axes,
        [tr_preds, vl_preds, ts_preds],
        [tr_labels, vl_labels, ts_labels],
        ["Training", "Validation", "Testing"]):
        report = classification_report(labels, preds,
                                       target_names=class_names, zero_division=0)
        ax.axis('off')
        ax.set_title(f"Classification Report — {title}", fontweight='bold')
        ax.text(0, 1, report, fontsize=7, family='monospace', verticalalignment='top')
        print(f"\n{'='*50}\nClassification Report — {title}\n{'='*50}")
        print(report)
    plt.tight_layout(); plt.savefig("classification_reports.png", dpi=150); plt.close() # <-- plt.show() hata diya

    print("\nSaved: curves.png | confusion_matrices.png | per_class_accuracy.png | roc_curves.png | classification_reports.png")


# ==========================================
# 10. RAG Setup
# ==========================================
def load_knowledge_base(filepath="recommendations.txt"):
    docs = []
    current = {}
    with open(filepath, "r", encoding="utf-8") as f:
        for line in f:
            line = line.strip()
            if not line:
                if current:
                    docs.append(current)
                    current = {}
                continue
            if ":" in line:
                key, val = line.split(":", 1)
                current[key.strip()] = val.strip()
    if current:
        docs.append(current)
    return docs

print("\nLoading RAG knowledge base...")
knowledge_base = load_knowledge_base("recommendations.txt")

embedder             = SentenceTransformer("all-MiniLM-L6-v2")
condition_texts      = [doc["CONDITION"] for doc in knowledge_base]
condition_embeddings = embedder.encode(condition_texts, convert_to_numpy=True).astype("float32")
faiss.normalize_L2(condition_embeddings)

rag_index = faiss.IndexFlatIP(condition_embeddings.shape[1])
rag_index.add(condition_embeddings)
print(f"RAG ready — {len(knowledge_base)} conditions loaded\n")

def retrieve_recommendations(detected_label: str):
    query_emb = embedder.encode([detected_label], convert_to_numpy=True).astype("float32")
    faiss.normalize_L2(query_emb)
    distances, indices = rag_index.search(query_emb, k=1)
    return knowledge_base[indices[0][0]], float(distances[0][0])

# ==========================================
# 11. Core Predict Function (shared)
# ==========================================
def run_prediction(pil_image: Image.Image):
    """PIL Image leke prediction + RAG result return karta hai"""
    adapter.load_state_dict(torch.load("best_skin_model.pth", map_location=device))
    adapter.eval()

    img_input = preprocess(pil_image).unsqueeze(0).to(device)

    with torch.no_grad():
        features = model.encode_image(img_input).float()
        features /= features.norm(dim=-1, keepdim=True)
        outputs  = F.softmax(adapter(features), dim=1)

    top_idx    = torch.argmax(outputs, dim=1).item()
    label      = class_names[top_idx]
    confidence = float(outputs[0][top_idx]) * 100
    rec, score = retrieve_recommendations(label)

    return label, confidence, score, rec

# ==========================================
# 12. FastAPI Setup
# ==========================================
fastapi_app = FastAPI(title="Elara AI Skin API", version="1.0.0")

# CORS — PHP/JS dashboard se connect karne ke liye
fastapi_app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],           # production mein apna domain dena
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@fastapi_app.get("/")
def root():
    return {"message": "Elara AI Skin API is running", "status": "ok"}

@fastapi_app.get("/health")
def health():
    return {"status": "healthy", "device": device, "classes": num_classes}

@fastapi_app.post("/predict")
async def predict(file: UploadFile = File(...)):
    """
    Image upload karo → condition detect + RAG recommendations milti hain
    PHP dashboard se aise call karo:
    fetch('http://localhost:8000/predict', { method:'POST', body: formData })
    """
    try:
        contents = await file.read()
        pil_image = Image.open(io.BytesIO(contents)).convert("RGB")

        label, confidence, score, rec = run_prediction(pil_image)

        return JSONResponse(content={
            "success": True,
            "condition": label,
            "confidence": round(confidence, 2),
            "rag_score": round(score, 4),
            "recommendations": {
                "home_remedies":  rec.get("HOME_REMEDIES", "N/A"),
                "ingredients":    rec.get("INGREDIENTS",   "N/A"),
                "products":       rec.get("PRODUCTS",      "N/A"),
                "do":             rec.get("DO",            "N/A"),
                "avoid":          rec.get("AVOID",         "N/A"),
                "lifestyle":      rec.get("LIFESTYLE",     "N/A"),
                "sleep":          rec.get("SLEEP",         "N/A"),
                "water":          rec.get("WATER",         "N/A"),
            }
        })

    except Exception as e:
        return JSONResponse(status_code=500, content={"success": False, "error": str(e)})

@fastapi_app.get("/classes")
def get_classes():
    """Saari classes ki list"""
    return {"classes": class_names, "total": num_classes}

# ==========================================
# 13. Gradio Predict Function
# ==========================================
def predict_image_gradio(img):
    if img is None:
        return "No image uploaded."

    pil_image = Image.fromarray(img)
    label, confidence, score, rec = run_prediction(pil_image)

    result = f"""DETECTED CONDITION : {label}
CONFIDENCE         : {confidence:.2f}%
RAG MATCH SCORE    : {score:.4f}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

HOME REMEDIES
{rec.get('HOME_REMEDIES', 'N/A')}

KEY INGREDIENTS
{rec.get('INGREDIENTS', 'N/A')}

PRODUCT SUGGESTIONS
{rec.get('PRODUCTS', 'N/A')}

WHAT TO DO
{rec.get('DO', 'N/A')}

WHAT TO AVOID
{rec.get('AVOID', 'N/A')}

LIFESTYLE TIPS
{rec.get('LIFESTYLE', 'N/A')}

SLEEP  |  {rec.get('SLEEP', 'N/A')}
WATER  |  {rec.get('WATER', 'N/A')}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Note: Consult a dermatologist for medical advice."""

    return result

# ==========================================
# 14. Gradio Interface
# ==========================================
gradio_app = gr.Interface(
    fn=predict_image_gradio,
    inputs=gr.Image(label="Upload Face Image"),
    outputs=gr.Textbox(label="Skin Analysis & Recommendations", lines=30),
    title="Elara AI — Skin Condition Classifier",
    description="Upload a facial image. CLIP model detects the condition, RAG retrieves personalized recommendations.",
    theme=gr.themes.Soft()
)

# ==========================================
# 15. Run FastAPI Server Only
# ==========================================
if __name__ == "__main__":
    import uvicorn
    print("\nElara AI Skin API is starting on port 8000...")
    uvicorn.run(fastapi_app, host="127.0.0.1", port=8000)

# ==========================================
# 16. Save Final Model
# ==========================================
torch.save(adapter.state_dict(), "final_skin_model.pth")
print("Final model saved successfully")
# ==========================================
# 16. Save Final Model
# ==========================================
torch.save(adapter.state_dict(), "final_skin_model.pth")
print("Final model saved successfully")

# --- AB YAHAN SECTIONS KE BAAD CALL KAREIN ---
if __name__ == '__main__':
    print("\nGenerating and saving evaluation graphs...")
    plot_results()