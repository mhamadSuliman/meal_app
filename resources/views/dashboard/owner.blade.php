<x-app-layout>
    {{-- ============ FONTS ============ --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Fraunces:opsz,wght@9..144,400;9..144,700;9..144,900&family=Space+Grotesk:wght@700;900&display=swap" rel="stylesheet">

    <style>
        .owner-dash {
            font-family: 'Cairo', sans-serif; direction: rtl; color:#f5f5f4;
            position:relative; overflow:hidden; min-height:100vh;
            background:
              radial-gradient(ellipse at top right, #7c2d12 0%, transparent 50%),
              radial-gradient(ellipse at bottom left, #431407 0%, transparent 50%),
              linear-gradient(180deg, #1c0d06 0%, #0c0604 100%);
        }
        .owner-dash h1, .owner-dash h2, .owner-dash h3, .owner-dash p, .owner-dash span, .owner-dash a, .owner-dash label { color: inherit; }

        /* Subtle noise/grain */
        .owner-dash::before {
            content:''; position:absolute; inset:0; z-index:0; pointer-events:none;
            opacity:.4;
            background-image: url("data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' stitchTiles='stitch'/%3E%3CfeColorMatrix values='0 0 0 0 1 0 0 0 0 .7 0 0 0 0 .4 0 0 0 .08 0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)'/%3E%3C/svg%3E");
        }
        /* Decorative glow */
        .owner-dash::after {
            content:''; position:absolute; top:-150px; right:-100px; width:600px; height:600px;
            background: radial-gradient(circle, rgba(251,146,60,.25), transparent 60%);
            z-index:0; pointer-events:none;
            animation: glow-float 12s ease-in-out infinite alternate;
        }
        @keyframes glow-float {
            0% { transform: translate(0,0) scale(1); }
            100% { transform: translate(-80px, 60px) scale(1.15); }
        }
        .owner-dash > * { position: relative; z-index: 1; }

        .serif { font-family: 'Fraunces', serif; font-optical-sizing: auto; }

        /* Card base */
        .menu-card {
            background: linear-gradient(145deg, rgba(255,240,220,.04), rgba(255,240,220,.01));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(251,191,36,.12);
            border-radius: 20px;
            position: relative;
        }

        /* Hero ribbon strips */
        .ribbon {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 6px 14px; border-radius: 999px;
            background: linear-gradient(135deg, rgba(251,146,60,.2), rgba(239,68,68,.1));
            border: 1px solid rgba(251,146,60,.35);
            color: #fed7aa; font-size: 12px; font-weight: 800; letter-spacing: .2em;
        }

        /* Stat cards */
        .stat-block { transition: all .4s cubic-bezier(.2,.8,.2,1); position:relative; overflow:hidden; }
        .stat-block:hover { transform: translateY(-6px); }
        .stat-block .side {
            position:absolute; right:0; top:20px; bottom:20px; width:3px;
            border-radius:3px; background: var(--c);
            box-shadow: 0 0 20px var(--c);
        }
        .stat-block .badge-live {
            display: inline-flex; align-items:center; gap: 6px;
            font-size: 10px; font-weight: 900; letter-spacing: .15em;
            padding: 4px 10px; border-radius: 999px;
            background: color-mix(in srgb, var(--c) 15%, transparent);
            color: var(--c); border: 1px solid color-mix(in srgb, var(--c) 30%, transparent);
        }
        .stat-block .ico {
            width: 48px; height: 48px; border-radius: 14px;
            display:flex; align-items:center; justify-content:center;
            background: color-mix(in srgb, var(--c) 15%, transparent);
            border: 1px solid color-mix(in srgb, var(--c) 30%, transparent);
            color: var(--c);
            box-shadow: 0 8px 20px -8px var(--c);
        }

        /* Today section */
        .today-hero {
            background: linear-gradient(135deg, rgba(239,68,68,.15), rgba(251,146,60,.08) 50%, transparent);
            border: 1.5px solid rgba(251,146,60,.25);
            border-radius: 24px;
            position: relative; overflow: hidden;
        }
        .today-hero::before {
            content:''; position:absolute; top:-50%; left:-30%; width:80%; height:200%;
            background: radial-gradient(circle, rgba(251,146,60,.3), transparent 60%);
            filter: blur(60px); animation: glow-float 10s ease-in-out infinite alternate;
        }

        /* Meal card */
        .meal-card {
            background: linear-gradient(145deg, rgba(255,240,220,.04), rgba(255,240,220,.01));
            border: 1px solid rgba(251,191,36,.12);
            border-radius: 18px;
            padding: 22px;
            position: relative; overflow: hidden;
            transition: all .4s cubic-bezier(.2,.8,.2,1);
        }
        .meal-card::before {
            content:''; position: absolute; inset: 0; border-radius: 18px;
            background: linear-gradient(135deg, rgba(251,146,60,.15), transparent 50%);
            opacity: 0; transition: opacity .4s;
        }
        .meal-card:hover {
            transform: translateY(-8px) rotate(-.3deg);
            border-color: rgba(251,146,60,.4);
            box-shadow: 0 30px 60px -20px rgba(0,0,0,.6), 0 0 40px -10px rgba(251,146,60,.3);
        }
        .meal-card:hover::before { opacity: 1; }
        .meal-card .meal-num {
            font-family: 'Fraunces', serif;
            font-weight: 900; font-style: italic;
            font-size: 72px; line-height: 1;
            background: linear-gradient(135deg, rgba(251,191,36,.25), rgba(251,146,60,.05));
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            position: absolute; top: -10px; left: 18px;
            user-select: none; pointer-events: none;
        }
        .meal-card .delete-btn {
            opacity: 0; transform: translateY(10px);
            transition: all .3s;
        }
        .meal-card:hover .delete-btn { opacity: 1; transform: translateY(0); }

        .price-tag {
            font-family: 'Fraunces', serif; font-weight: 900;
            font-size: 36px; line-height: 1;
            background: linear-gradient(135deg, #fbbf24, #fb923c);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .price-currency {
            font-family: 'Cairo', sans-serif; font-weight: 700;
            font-size: 13px; color: #fed7aa;
            margin-right: 4px;
        }

        /* Buttons */
        .btn-add {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; font-weight: 900;
            padding: 12px 24px; border-radius: 14px;
            box-shadow: 0 15px 35px -10px rgba(16,185,129,.5), inset 0 1px 0 rgba(255,255,255,.3);
            transition: all .3s;
            display: inline-flex; align-items: center; gap: 10px;
        }
        .btn-add:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 20px 40px -10px rgba(16,185,129,.7); }

        .btn-delete {
            background: rgba(239,68,68,.12);
            color: #fca5a5;
            border: 1px solid rgba(239,68,68,.3);
            font-weight: 700; font-size: 13px;
            padding: 8px 14px; border-radius: 10px;
            transition: all .3s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-delete:hover { background: #ef4444; color: #fff; border-color: #ef4444; box-shadow: 0 10px 25px -10px rgba(239,68,68,.6); }

        /* Divider with text */
        .divider-text {
            display: flex; align-items: center; gap: 16px;
            color: #78716c; font-size: 11px; font-weight: 800; letter-spacing: .3em;
        }
        .divider-text::before, .divider-text::after {
            content: ''; flex: 1; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(251,191,36,.3), transparent);
        }

        /* Animations */
        @keyframes fadeUp { from {opacity:0; transform:translateY(24px);} to {opacity:1; transform:translateY(0);} }
        .fade-up { animation: fadeUp .7s cubic-bezier(.2,.8,.2,1) forwards; opacity:0; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .4; } }
        .live-dot { animation: pulse 2s infinite; }

        .count-up { font-variant-numeric: tabular-nums; }
    </style>

    <div class="owner-dash p-6 md:p-10">

        {{-- ================= HERO HEADER ================= --}}
        <div class="mb-10 fade-up">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="ribbon">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400 live-dot"></span>
                            OWNER PANEL · لوحة المالك
                        </span>
                    </div>
                    <p class="text-orange-300 text-sm font-bold mb-2 tracking-wider">— مرحباً بك في مطعمك</p>
                    <h1 class="serif text-5xl md:text-7xl font-black leading-none">
                        <span style="color:#fef3c7">{{ $restaurant->name }}</span>
                    </h1>
                    <div class="flex items-center gap-3 mt-4">
                        <div class="flex -space-x-2">
                            <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        </div>
                        <p class="text-amber-200/70 text-sm italic serif">
                            "أدر مطعمك كالمحترفين — كل طبق، كل طلب، بين يديك"
                        </p>
                    </div>
                </div>

                <div class="menu-card px-5 py-4 flex items-center gap-3">
                    <div class="relative">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                        <div class="absolute inset-0 w-2.5 h-2.5 rounded-full bg-green-400 animate-ping"></div>
                    </div>
                    <div>
                        <p class="text-green-300 text-xs font-black tracking-wider">OPEN · يعمل الآن</p>
                        <p class="text-amber-100/60 text-xs">آخر تحديث: {{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TODAY'S PULSE ================= --}}
        <div class="today-hero p-7 md:p-8 mb-8 fade-up" style="animation-delay:.1s">
            <div class="flex items-center gap-2 mb-5">
                <span class="w-1.5 h-6 bg-gradient-to-b from-red-400 to-orange-500 rounded-full"></span>
                <h2 class="serif text-2xl font-black" style="color:#fef3c7">نبض اليوم</h2>
                <span class="text-xs font-black tracking-[.2em] text-red-300/80 mr-2">· TODAY'S PULSE</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 relative">
                {{-- أرباح اليوم --}}
                <div class="menu-card stat-block p-6" style="--c:#fbbf24">
                    <div class="side"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="ico">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="badge-live">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 live-dot"></span>
                            LIVE
                        </span>
                    </div>
                    <p class="text-amber-200/70 text-sm font-semibold mb-2">📅 أرباح اليوم</p>
                    <h3 class="serif text-5xl font-black count-up" style="color:#fef3c7" data-target="{{ (float) $todayRevenue }}" data-testid="today-revenue">{{ $todayRevenue }}</h3>
                </div>

                {{-- طلبات اليوم --}}
                <div class="menu-card stat-block p-6" style="--c:#f87171">
                    <div class="side"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="ico">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="badge-live">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 live-dot"></span>
                            HOT
                        </span>
                    </div>
                    <p class="text-amber-200/70 text-sm font-semibold mb-2">🔥 طلبات اليوم</p>
                    <h3 class="serif text-5xl font-black count-up" style="color:#fef3c7" data-target="{{ (int) $todayOrders->count() }}" data-testid="today-orders">{{ $todayOrders->count() }}</h3>
                </div>
            </div>
        </div>

        {{-- ================= ALL TIME STATS ================= --}}
        <div class="mb-10 fade-up" style="animation-delay:.15s">
            <div class="divider-text mb-6">ALL TIME · الإحصائيات الإجمالية</div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- إجمالي الأرباح --}}
                <div class="menu-card stat-block p-6" style="--c:#34d399">
                    <div class="side"></div>
                    <div class="ico mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <p class="text-amber-200/70 text-xs font-bold tracking-wider mb-1">إجمالي الأرباح</p>
                    <h3 class="serif text-4xl font-black count-up" style="color:#fef3c7" data-target="{{ (float) $totalRevenue }}" data-testid="total-revenue">{{ $totalRevenue }}</h3>
                </div>

                {{-- عدد الطلبات --}}
                <div class="menu-card stat-block p-6" style="--c:#60a5fa">
                    <div class="side"></div>
                    <div class="ico mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-amber-200/70 text-xs font-bold tracking-wider mb-1">عدد الطلبات</p>
                    <h3 class="serif text-4xl font-black count-up" style="color:#fef3c7" data-target="{{ (int) $totalOrders }}" data-testid="total-orders">{{ $totalOrders }}</h3>
                </div>

                {{-- عدد الوجبات --}}
                <div class="menu-card stat-block p-6" style="--c:#a78bfa">
                    <div class="side"></div>
                    <div class="ico mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </div>
                    <p class="text-amber-200/70 text-xs font-bold tracking-wider mb-1">عدد الوجبات</p>
                    <h3 class="serif text-4xl font-black count-up" style="color:#fef3c7" data-target="{{ $meals->count() }}">{{ $meals->count() }}</h3>
                </div>

                {{-- متوسط السعر --}}
                @php $avgPrice = $meals->count() ? round($meals->avg('price'), 2) : 0; @endphp
                <div class="menu-card stat-block p-6" style="--c:#fb923c">
                    <div class="side"></div>
                    <div class="ico mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5"/></svg>
                    </div>
                    <p class="text-amber-200/70 text-xs font-bold tracking-wider mb-1">متوسط سعر الوجبة</p>
                    <h3 class="serif text-4xl font-black count-up" style="color:#fef3c7" data-target="{{ $avgPrice }}">{{ $avgPrice }}</h3>
                </div>
            </div>
        </div>

        {{-- ================= MENU / MEALS ================= --}}
        <div class="fade-up" style="animation-delay:.2s">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
                <div>
                    <p class="text-orange-400 text-xs font-black tracking-[.3em] mb-2">— قائمة الطعام —</p>
                    <h2 class="serif text-4xl md:text-5xl font-black" style="color:#fef3c7">
                        🍴 قائمة وجباتنا
                    </h2>
                    <p class="text-amber-200/60 text-sm mt-2 italic serif">جميع الأطباق المُقدَّمة من مطبخك</p>
                </div>

                <a href="/owner/meals/create" class="btn-add" data-testid="add-meal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    إضافة وجبة جديدة
                </a>
            </div>

            @if($meals->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($meals as $i => $meal)
                        @php
                            $roman = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
                            $num = $roman[$i] ?? (string)($i+1);
                        @endphp
                        <div class="meal-card">
                            <span class="meal-num">{{ $num }}</span>

                            <div class="relative pt-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 h-px bg-orange-400/60"></span>
                                        <span class="text-orange-400 text-[10px] font-black tracking-widest">DISH #{{ str_pad($meal->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>

                                <h3 class="serif text-2xl font-black mb-1 leading-tight" style="color:#fef3c7">
                                    {{ $meal->name }}
                                </h3>
                                <p class="text-amber-200/50 text-xs italic serif mb-5">— طبق من قائمتنا —</p>

                                <div class="flex items-end justify-between pt-4 border-t border-orange-400/10">
                                    <div>
                                        <p class="text-amber-200/50 text-[10px] font-bold tracking-widest mb-1">PRICE</p>
                                        <div class="flex items-baseline">
                                            <span class="price-tag">{{ $meal->price }}</span>
                                            <span class="price-currency">ل.س</span>
                                        </div>
                                    </div>

                                    <form method="POST" action="/owner/meals/{{ $meal->id }}" class="delete-btn"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الوجبة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete" data-testid="delete-meal-{{ $meal->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 7V4a1 1 0 011-1h2a1 1 0 011 1v3"/></svg>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="menu-card p-12 text-center">
                    <div class="text-6xl mb-4 opacity-40">🍽️</div>
                    <h3 class="serif text-2xl font-black mb-2" style="color:#fef3c7">قائمتك فاضية لسا</h3>
                    <p class="text-amber-200/60 mb-6">ابدأ بإضافة أول وجبة لمطعمك واجذب الزبائن</p>
                    <a href="/owner/meals/create" class="btn-add">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        أضف أول وجبة
                    </a>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="text-center mt-16 text-amber-200/30 text-xs serif italic">
            <p>— كل وجبة تحكي قصة · {{ $restaurant->name }} —</p>
        </div>
    </div>

    {{-- ============ COUNTER ANIMATION ============ --}}
    <script>
        document.querySelectorAll('.count-up').forEach(el => {
            const target = parseFloat(el.dataset.target) || 0;
            const isInt = Number.isInteger(target);
            const duration = 1400;
            const start = performance.now();
            function tick(now) {
                const p = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                const val = target * eased;
                el.textContent = isInt ? Math.floor(val).toLocaleString() : val.toFixed(2);
                if (p < 1) requestAnimationFrame(tick);
                else el.textContent = isInt ? Math.floor(target).toLocaleString() : (target % 1 === 0 ? target.toLocaleString() : target.toFixed(2));
            }
            requestAnimationFrame(tick);
        });
    </script>
</x-app-layout>