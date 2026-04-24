

<x-app-layout>
    {{-- ============ FONTS ============ --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Space+Grotesk:wght@700;900&display=swap" rel="stylesheet">

    <style>
        .form-page { font-family: 'Cairo', sans-serif; direction: rtl; color:#e2e8f0; position:relative; overflow:hidden; min-height:100vh; }
        .form-page h1, .form-page h2, .form-page p, .form-page label, .form-page span, .form-page a { color: inherit; }

        /* Animated mesh background */
        .form-page::before {
            content:''; position:absolute; inset:0; z-index:0;
            background:
              radial-gradient(at 15% 20%, rgba(52,211,153,.18) 0, transparent 40%),
              radial-gradient(at 85% 15%, rgba(251,191,36,.15) 0, transparent 40%),
              radial-gradient(at 50% 95%, rgba(167,139,250,.12) 0, transparent 45%);
            animation: meshMove 18s ease-in-out infinite alternate;
        }
        .form-page::after {
            content:''; position:absolute; inset:0; z-index:0; pointer-events:none;
            background-image:
              linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
              linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse at center, #000 40%, transparent 75%);
        }
        @keyframes meshMove {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.15) rotate(4deg); }
        }
        .form-page > * { position: relative; z-index: 1; }

        .glass-card {
            background: linear-gradient(145deg, rgba(255,255,255,.05), rgba(255,255,255,.01));
            backdrop-filter: blur(24px) saturate(140%);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 24px;
            position: relative;
        }
        .glass-card::before {
            content:''; position:absolute; inset:0; border-radius:24px; padding:1px;
            background: linear-gradient(135deg, rgba(255,255,255,.15), transparent 40%, rgba(255,255,255,.05));
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor; mask-composite: exclude;
            pointer-events:none;
        }

        /* Input wrapper with icon */
        .field { position: relative; }
        .field label {
            display:flex; align-items:center; gap:8px;
            color:#fbbf24; font-weight:800; font-size:13px;
            letter-spacing:.5px; margin-bottom:10px;
            text-transform: uppercase;
        }
        .field label .dot {
            width:6px; height:6px; border-radius:50%;
            background: #fbbf24; box-shadow: 0 0 10px #fbbf24;
        }
        .field .input-wrap {
            position: relative;
            transition: transform .3s;
        }
        .field .input-wrap .icon {
            position: absolute; top: 50%; right: 16px; transform: translateY(-50%);
            color: #64748b; pointer-events: none; transition: color .3s;
        }
        .nice-input, .nice-select {
            width: 100%;
            background: rgba(10, 18, 41, .6);
            color: #f1f5f9 !important;
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 14px 48px 14px 18px;
            font-family: 'Cairo', sans-serif;
            font-size: 15px;
            font-weight: 600;
            transition: all .3s;
            outline: none;
        }
        .nice-input::placeholder { color: #64748b; font-weight:500; }
        .nice-input:focus, .nice-select:focus {
            border-color: #fbbf24;
            background: rgba(10, 18, 41, .9);
            box-shadow: 0 0 0 4px rgba(251,191,36,.12), 0 10px 30px -10px rgba(251,191,36,.2);
        }
        .field .input-wrap:focus-within .icon { color: #fbbf24; }

        .nice-select {
            appearance: none; -webkit-appearance: none;
            padding-left: 48px;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='8' viewBox='0 0 14 8' fill='none'%3E%3Cpath d='M1 1.5L7 6.5L13 1.5' stroke='%23fbbf24' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 18px center;
        }
        .nice-select option { background: #0a1229; color: #f1f5f9; padding: 10px; }

        .btn-gold {
            background: linear-gradient(135deg, #fbbf24, #f97316);
            color: #1a0f00;
            font-weight: 900;
            font-size: 15px;
            padding: 14px 32px;
            border-radius: 14px;
            box-shadow: 0 15px 35px -10px rgba(251,191,36,.5), inset 0 1px 0 rgba(255,255,255,.4);
            transition: all .3s;
            display: inline-flex; align-items: center; gap: 10px;
            border: none; cursor: pointer;
        }
        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -10px rgba(251,191,36,.7);
        }
        .btn-ghost {
            background: rgba(255,255,255,.04);
            color: #e2e8f0;
            border: 1.5px solid rgba(255,255,255,.1);
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 14px;
            transition: all .3s;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.2);
            transform: translateY(-2px);
        }

        /* Preview card */
        .preview-card {
            background: linear-gradient(145deg, rgba(251,191,36,.08), rgba(249,115,22,.02));
            border: 1.5px dashed rgba(251,191,36,.25);
            border-radius: 20px;
            padding: 28px;
            transition: all .3s;
        }
        .preview-avatar {
            width: 80px; height: 80px; border-radius: 22px;
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-weight:900; font-size: 36px;
            font-family: 'Space Grotesk', sans-serif;
            background: linear-gradient(135deg, #fb923c, #ef4444);
            box-shadow: 0 15px 35px -10px rgba(251,115,22,.6);
            transition: all .4s;
        }

        .neon-text {
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 50%, #f472b6 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px rgba(251,191,36,.3));
        }

        /* Validation errors */
        .error-msg {
            margin-top: 8px; color: #fca5a5; font-size: 13px; font-weight: 600;
            display: flex; align-items: center; gap: 6px;
        }

        @keyframes fadeUp { from {opacity:0; transform:translateY(24px);} to {opacity:1; transform:translateY(0);} }
        .fade-up { animation: fadeUp .7s cubic-bezier(.2,.8,.2,1) forwards; opacity:0; }

        @keyframes popIn { from {opacity:0; transform:scale(.85);} to {opacity:1; transform:scale(1);} }
        .pop-in { animation: popIn .5s cubic-bezier(.2,.8,.2,1) forwards; }

        /* Back link */
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: #94a3b8; font-weight: 700; font-size: 14px;
            transition: all .3s;
        }
        .back-link:hover { color: #fbbf24; transform: translateX(6px); }
    </style>

    <div class="form-page p-6 md:p-10" style="background: radial-gradient(ellipse at top, #0a1229 0%, #050814 60%, #020409 100%);">

        {{-- ============ Back ============ --}}
        <a href="/admin/dashboard" class="back-link mb-6 fade-up">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
            العودة للوحة التحكم
        </a>

        {{-- ============ Header ============ --}}
        <div class="mb-10 fade-up" style="animation-delay:.05s">
            <div class="flex items-center gap-3 mb-3">
                <span class="inline-block w-10 h-[2px] bg-gradient-to-r from-yellow-400 to-transparent"></span>
                <p class="text-yellow-400 text-xs font-black tracking-[.3em]">RESTAURANTS • NEW ENTRY</p>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white leading-tight">
                إضافة
                <span class="neon-text">مطعم جديد</span>
            </h1>
            <p class="text-slate-300 mt-3 text-lg">أضف مطعماً جديداً إلى المنصة وحدّد مدينته ومالكه</p>
        </div>

        {{-- ============ Grid: Form + Preview ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 max-w-6xl">

            {{-- ============ FORM ============ --}}
            <form method="POST" action="/admin/restaurants" class="glass-card p-8 md:p-10 lg:col-span-3 fade-up" style="animation-delay:.1s">
                @csrf

                <div class="flex items-center gap-3 mb-8 pb-6 border-b border-white/5">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                         style="background: linear-gradient(135deg,#34d399,#059669); box-shadow: 0 10px 25px -10px #10b981;">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white">بيانات المطعم</h2>
                        <p class="text-slate-400 text-sm">جميع الحقول مطلوبة</p>
                    </div>
                </div>

                {{-- اسم المطعم --}}
                <div class="field mb-6">
                    <label for="name">
                        <span class="dot"></span>
                        اسم المطعم
                    </label>
                    <div class="input-wrap">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               placeholder="مثال: مطعم الذواقة"
                               class="nice-input" data-testid="input-name" autocomplete="off">
                        <svg class="icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    @error('name') <p class="error-msg">⚠️ {{ $message }}</p> @enderror
                </div>

                {{-- المدينة --}}
                <div class="field mb-6">
                    <label for="city_id">
                        <span class="dot"></span>
                        المدينة
                    </label>
                    <div class="input-wrap">
                        <select id="city_id" name="city_id" required class="nice-select" data-testid="select-city">
                            <option value="" disabled selected>اختر المدينة...</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    @error('city_id') <p class="error-msg">⚠️ {{ $message }}</p> @enderror
                </div>

                {{-- صاحب المطعم --}}
                <div class="field mb-8">
                    <label for="user_id">
                        <span class="dot"></span>
                        صاحب المطعم
                    </label>
                    <div class="input-wrap">
                        <select id="user_id" name="user_id" required class="nice-select" data-testid="select-owner">
                            <option value="" disabled selected>اختر صاحب المطعم...</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ old('user_id') == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    @error('user_id') <p class="error-msg">⚠️ {{ $message }}</p> @enderror
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-white/5">
                    <button type="submit" class="btn-gold w-full sm:w-auto justify-center" data-testid="submit-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        حفظ المطعم
                    </button>
                    <a href="/admin/dashboard" class="btn-ghost w-full sm:w-auto justify-center">
                        إلغاء
                    </a>
                </div>
            </form>

            {{-- ============ LIVE PREVIEW ============ --}}
            <div class="lg:col-span-2 fade-up" style="animation-delay:.2s">
                <div class="glass-card p-7 sticky top-6">
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-yellow-400 to-orange-500 rounded-full"></span>
                        <h3 class="text-lg font-black text-white">معاينة مباشرة</h3>
                    </div>

                    <div class="preview-card">
                        <div class="flex flex-col items-center text-center">
                            <div id="previewAvatar" class="preview-avatar pop-in">؟</div>
                            <p class="text-yellow-400 text-xs font-black tracking-widest mt-5 mb-1">RESTAURANT NAME</p>
                            <p id="previewName" class="text-white font-black text-2xl mb-4">لم يتم الإدخال بعد</p>

                            <div class="w-full grid grid-cols-2 gap-3 mt-3">
                                <div class="bg-white/5 rounded-xl p-3 border border-white/5">
                                    <p class="text-slate-400 text-xs font-semibold mb-1">📍 المدينة</p>
                                    <p id="previewCity" class="text-white text-sm font-bold truncate">—</p>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 border border-white/5">
                                    <p class="text-slate-400 text-xs font-semibold mb-1">👤 المالك</p>
                                    <p id="previewOwner" class="text-white text-sm font-bold truncate">—</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 rounded-xl bg-blue-500/5 border border-blue-400/20">
                        <p class="text-blue-300 text-xs font-bold flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>المعاينة تتحدّث تلقائياً كلما عبّأت الحقول. تأكّد من البيانات قبل الحفظ.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ LIVE PREVIEW SCRIPT ============ --}}
    <script>
        const nameInput = document.getElementById('name');
        const cityInput = document.getElementById('city_id');
        const ownerInput = document.getElementById('user_id');
        const pName = document.getElementById('previewName');
        const pCity = document.getElementById('previewCity');
        const pOwner = document.getElementById('previewOwner');
        const pAvatar = document.getElementById('previewAvatar');

        const gradients = [
            'linear-gradient(135deg,#fb923c,#ef4444)',
            'linear-gradient(135deg,#a78bfa,#6366f1)',
            'linear-gradient(135deg,#34d399,#059669)',
            'linear-gradient(135deg,#f472b6,#db2777)',
            'linear-gradient(135deg,#fbbf24,#f59e0b)',
            'linear-gradient(135deg,#60a5fa,#2563eb)',
        ];

        function updatePreview() {
            const name = nameInput.value.trim();
            pName.textContent = name || 'لم يتم الإدخال بعد';
            if (name) {
                const letter = name.charAt(0).toUpperCase();
                pAvatar.textContent = letter;
                const idx = letter.charCodeAt(0) % gradients.length;
                pAvatar.style.background = gradients[idx];
                pAvatar.classList.remove('pop-in'); void pAvatar.offsetWidth; pAvatar.classList.add('pop-in');
            } else {
                pAvatar.textContent = '؟';
                pAvatar.style.background = 'linear-gradient(135deg,#475569,#334155)';
            }

            const cityOpt = cityInput.options[cityInput.selectedIndex];
            pCity.textContent = (cityOpt && cityOpt.value) ? cityOpt.text : '—';

            const ownerOpt = ownerInput.options[ownerInput.selectedIndex];
            pOwner.textContent = (ownerOpt && ownerOpt.value) ? ownerOpt.text : '—';
        }

        nameInput.addEventListener('input', updatePreview);
        cityInput.addEventListener('change', updatePreview);
        ownerInput.addEventListener('change', updatePreview);
        updatePreview();
    </script>
</x-app-layout>