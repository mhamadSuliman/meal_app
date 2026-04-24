<x-app-layout>

<link rel="preconnect" href__="https://fonts.googleapis.com">
<link href__="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
* { font-family: 'Tajawal', sans-serif; }

.meal-page {
    min-height: 100vh;
    background: #faf8f5;
    padding: 40px 20px;
    direction: rtl;
    position: relative;
    overflow: hidden;
}
.meal-page::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 350px; height: 350px;
    background: rgba(234, 88, 12, 0.06);
    border-radius: 50%;
    pointer-events: none;
}
.meal-page::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 280px; height: 280px;
    background: rgba(34, 197, 94, 0.05);
    border-radius: 50%;
    pointer-events: none;
}

.meal-container {
    max-width: 560px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* Header */
.meal-header {
    text-align: center;
    margin-bottom: 36px;
    animation: fadeDown 0.5s ease;
}
.meal-header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px; height: 64px;
    background: rgba(234, 88, 12, 0.1);
    border-radius: 20px;
    margin-bottom: 14px;
    font-size: 28px;
}
.meal-header h1 {
    font-size: 28px;
    font-weight: 800;
    color: #1a1008;
    margin: 0;
}
.meal-header p {
    color: #9a8070;
    margin: 6px 0 0;
    font-size: 14px;
}

/* Card */
.meal-card {
    background: #ffffff;
    border-radius: 28px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 20px 60px rgba(0,0,0,0.04);
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    animation: fadeUp 0.5s ease;
}

/* Image uploader */
.image-upload-area {
    border: 2px dashed #e5ddd5;
    border-radius: 18px;
    aspect-ratio: 16/9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    background: #faf8f5;
}
.image-upload-area:hover {
    border-color: rgba(234, 88, 12, 0.4);
    background: rgba(234, 88, 12, 0.02);
}
.image-upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.upload-icon {
    width: 60px; height: 60px;
    background: rgba(234, 88, 12, 0.1);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.upload-text { font-size: 13px; font-weight: 500; color: #2d2010; }
.upload-hint { font-size: 12px; color: #9a8070; }
.image-preview {
    display: none;
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    border-radius: 16px;
}

/* Form field */
.form-field { display: flex; flex-direction: column; gap: 8px; }
.form-field label {
    font-size: 13px;
    font-weight: 600;
    color: #7a6a5a;
}
.field-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    border: 2px solid #ede8e2;
    border-radius: 14px;
    padding: 12px 14px;
    background: #fff;
    transition: all 0.25s ease;
}
.field-wrapper:focus-within {
    border-color: #ea580c;
    background: rgba(234, 88, 12, 0.02);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.08);
}
.field-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #f5f0ea;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 2px;
    transition: all 0.25s ease;
}
.field-wrapper:focus-within .field-icon {
    background: #ea580c;
    filter: brightness(0) invert(1);
}
.field-wrapper input,
.field-wrapper textarea {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 14px;
    font-family: 'Tajawal', sans-serif;
    color: #1a1008;
    padding: 4px 0;
    width: 100%;
}
.field-wrapper textarea { resize: none; }
.field-wrapper input::placeholder,
.field-wrapper textarea::placeholder { color: rgba(154, 128, 112, 0.5); }

/* Type selector */
.type-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 6px 0;
}
.type-btn {
    padding: 7px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'Tajawal', sans-serif;
    border: none;
    cursor: pointer;
    background: #f5f0ea;
    color: #7a6a5a;
    transition: all 0.2s ease;
}
.type-btn:hover { background: #ede8e2; transform: scale(1.03); }
.type-btn.active {
    background: #ea580c;
    color: white;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
}

/* Price row */
.price-currency {
    font-size: 12px;
    color: #9a8070;
    font-weight: 600;
    white-space: nowrap;
    align-self: center;
}

/* Submit button */
.submit-btn {
    width: 100%;
    height: 56px;
    border-radius: 18px;
    background: #ea580c;
    color: white;
    font-family: 'Tajawal', sans-serif;
    font-size: 16px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 8px 24px rgba(234, 88, 12, 0.25);
    transition: all 0.25s ease;
    margin-top: 8px;
}
.submit-btn:hover {
    background: #c2410c;
    transform: translateY(-1px);
    box-shadow: 0 12px 32px rgba(234, 88, 12, 0.3);
}
.submit-btn:active { transform: translateY(0); }

/* Footer hint */
.form-hint {
    text-align: center;
    font-size: 12px;
    color: #b0a090;
    margin-top: 16px;
}

/* Animations */
@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-16px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div class="meal-page">
    <div class="meal-container">

        <!-- Header -->
        <div class="meal-header">
            <div class="meal-header-icon">🍽️</div>
            <h1>إضافة وجبة جديدة</h1>
            <p>أضف وجبة لذيذة لقائمتك ✨</p>
        </div>

        <!-- Card -->
        <div class="meal-card">

            <form action="/owner/meals" method="POST" enctype="multipart/form-data" id="mealForm">
                @csrf

                <!-- Image Upload -->
                <div class="image-upload-area" id="uploadArea">
                    <input type="file" name="image" accept="image/*" id="imageInput">
                    <img class="image-preview" id="imagePreview" src="" alt="معاينة">
                    <div class="upload-icon" id="uploadPlaceholder">🖼️</div>
                    <span class="upload-text" id="uploadText">اسحب الصورة هنا أو اضغط للرفع</span>
                    <span class="upload-hint" id="uploadHint">PNG, JPG حتى 10 ميغابايت</span>
                </div>

                <!-- Name -->
                <div class="form-field">
                    <label>اسم الوجبة</label>
                    <div class="field-wrapper">
                        <div class="field-icon">🍴</div>
                        <input type="text" name="name" placeholder="مثال: برجر لحم أنغوس" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-field">
                    <label>وصف الوجبة</label>
                    <div class="field-wrapper">
                        <div class="field-icon">📝</div>
                        <textarea name="description" rows="3" placeholder="أضف وصف شهي يجذب الزبائن..."></textarea>
                    </div>
                </div>

                <!-- Type -->
                <div class="form-field">
                    <label>نوع الوجبة</label>
                    <div class="field-wrapper" style="flex-wrap:wrap; gap:8px; padding:10px 14px;">
                        <div class="field-icon">🏷️</div>
                        <div class="type-options" id="typeOptions">
                            <button type="button" class="type-btn" onclick="selectType(this,'رئيسي')">🍽️ رئيسي</button>
                            <button type="button" class="type-btn" onclick="selectType(this,'مقبلات')">🥗 مقبلات</button>
                            <button type="button" class="type-btn" onclick="selectType(this,'حلويات')">🍰 حلويات</button>
                            <button type="button" class="type-btn" onclick="selectType(this,'مشروبات')">🥤 مشروبات</button>
                            <button type="button" class="type-btn" onclick="selectType(this,'سناك')">🍿 سناك</button>
                        </div>
                        <input type="hidden" name="type" id="typeValue">
                    </div>
                </div>

                <!-- Price -->
                <div class="form-field">
                    <label>السعر</label>
                    <div class="field-wrapper">
                        <div class="field-icon">💰</div>
                        <input type="number" name="price" step="0.01" min="0" placeholder="0.00" required>
                        <span class="price-currency">د.أ</span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn">
                    ✨ حفظ الوجبة
                </button>

            </form>
        </div>

        <p class="form-hint">💡 الحقول المطلوبة: اسم الوجبة والسعر</p>
    </div>
</div>

<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('imagePreview');
        preview.src = ev.target.result;
        preview.style.display = 'block';
        document.getElementById('uploadPlaceholder').style.display = 'none';
        document.getElementById('uploadText').style.display = 'none';
        document.getElementById('uploadHint').style.display = 'none';
    };
    reader.readAsDataURL(file);
});

// Type selector
function selectType(btn, value) {
    document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('typeValue').value = value;
}
</script>

</x-app-layout>