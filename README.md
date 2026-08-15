# Elara AI: Advanced Facial Skin Analysis & Condition Classification System

Elara AI is a cutting-edge vision-language framework designed for fine-grained facial skin condition classification and personalized clinical skincare recommendations. Built on **CLIP (ViT-B/32)** transfer learning with a specialized **Adapter module**, Elara AI effectively handles multi-class feature extraction on specialized facial image data, integrating **Retrieval-Augmented Generation (RAG)** to deliver actionable, medical-grade diagnostic insights.

---

## 📌 Dataset Overview

The system is trained and evaluated on a custom facial skin dataset hosted publicly on Kaggle:

* **Dataset Title:** Facial Images on General Purpose
* **Dataset Link:** [Kaggle Dataset](https://www.kaggle.com/datasets/sanaafzal9898/facial-images-on-general-purpose)
* **Dataset Creator:** Sana Afzal (`sanaafzal9898`)
* **Total Images:** 836 images
* **Categories / Classes:** 9 specialized facial skin categories
* **Domain Focus:** Fine-grained facial dermatological analysis and condition detection

---

## 🚀 Key Features & Architectural Highlights

1. **CLIP ViT-B/32 + Adapter Architecture**
   * Employs multimodal pre-trained visual embeddings with a lightweight Adapter layer optimized specifically for subtle facial skin feature variations.

2. **Advanced Training & Optimization Pipeline**
   * **Feature Caching:** Enhances computational efficiency and speeds up training iterations.
   * **Mixup Data Augmentation:** Improves generalization across subtle condition boundaries.
   * **Focal Loss:** Effectively combats class imbalance across small-scale datasets.
   * **Test-Time Augmentation (TTA):** Provides robust predictions during inference.

3. **RAG-Powered Recommendation Engine**
   * Beyond visual classification, Elara AI incorporates **Retrieval-Augmented Generation (RAG)** to offer contextualized, evidence-based skincare advice and clinical suggestions tailored to each detected condition.

---

## 📊 System Overview

| Parameter / Feature | Configuration / Value |
| :--- | :--- |
| **Model Backbone** | CLIP ViT-B/32 + Adapter |
| **Learning Strategy** | Transfer Learning |
| **Classification Accuracy** | **81.33%** |
| **Total Classes** | 9 |
| **Total Dataset Size** | 836 Images |
| **Recommendation Engine** | Retrieval-Augmented Generation (RAG) |

---
