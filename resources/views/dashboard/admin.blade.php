
<x-app-layout>
    {{-- ============ FONTS + LIBS ============ --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Space+Grotesk:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-0: #050814;
            --bg-1: #0a1229;
            --neon-y: #fbbf24;
            --neon-o: #fb923c;
            --neon-p: #a78bfa;
            --neon-g: #34d399;
            --neon-b: #60a5fa;
            --neon-r: #f87171;
        }

        .dash { font-family: 'Cairo', sans-serif; direction: rtl; color:#e2e8f0; position:relative; overflow:hidden; }
        .dash h1, .dash h2, .dash h3, .dash h4, .dash p, .dash span, .dash label, .dash a, .dash button { color: inherit; }

        /* Animated mesh background */
        .dash::before {
            content:''; position:absolute; inset:0; z-index:0;
            background:
              radial-gradient(at 20% 10%, rgba(167,139,250,.18) 0, transparent 40%),
              radial-gradient(at 80% 15%, rgba(251,191,36,.15) 0, transparent 40%),
              radial-gradient(at 50% 90%, rgba(52,211,153,.12) 0, transparent 45%),
              radial-gradient(at 90% 80%, rgba(96,165,250,.12) 0, transparent 40%);
            animation: meshMove 18s ease-in-out infinite alternate;
        }
        .dash::after {
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

        .dash > * { position: relative; z-index: 1; }

        /* Glass card */
        .glass-card {
            background: linear-gradient(145deg, rgba(255,255,255,.05), rgba(255,255,255,.01));
            backdrop-filter: blur(24px) saturate(140%);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            position: relative;
            transition: all .45s cubic-bezier(.2,.8,.2,1);
        }
        .glass-card::before {
            content:''; position:absolute; inset:0; border-radius:20px; padding:1px;
            background: linear-gradient(135deg, rgba(255,255,255,.15), transparent 40%, rgba(255,255,255,.05));
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor; mask-composite: exclude;
            pointer-events:none;
        }

        /* Stat card with neon side bar */
        .stat {
            position: relative; overflow: hidden;
        }
        .stat::after {
            content:''; position:absolute; top:18px; bottom:18px; right:0; width:3px;
            background: var(--c); border-radius:3px;
            box-shadow: 0 0 20px var(--c), 0 0 40px var(--c);
        }
        .stat:hover {
            transform: translateY(-8px) scale(1.015);
            box-shadow: 0 30px 60px -20px rgba(0,0,0,.6), 0 0 60px -20px var(--c);
            border-color: color-mix(in srgb, var(--c) 40%, transparent);
        }
        .stat .icon-wrap {
            width:52px; height:52px; border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            background: color-mix(in srgb, var(--c) 15%, transparent);
            border: 1px solid color-mix(in srgb, var(--c) 30%, transparent);
            box-shadow: 0 8px 24px -8px var(--c), inset 0 0 20px color-mix(in srgb, var(--c) 10%, transparent);
            color: var(--c);
        }
        .stat .pulse {
            width:8px; height:8px; border-radius:50%; background: var(--c);
            box-shadow: 0 0 10px var(--c);
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.3;} }

        .progress-bar {
            height:3px; background: rgba(255,255,255,.05); border-radius:3px; overflow:hidden; margin-top:14px;
        }
        .progress-bar > span {
            display:block; height:100%; background: linear-gradient(90deg, var(--c), color-mix(in srgb, var(--c) 40%, #fff));
            box-shadow: 0 0 10px var(--c);
            animation: fillBar 1.6s cubic-bezier(.2,.8,.2,1) forwards;
            width: 0;
        }
        @keyframes fillBar { to { width: var(--w, 70%); } }

        /* Order card */
        .order-card {
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px; padding: 18px;
            background: linear-gradient(145deg, rgba(255,255,255,.03), rgba(255,255,255,.01));
            transition: all .3s;
            position: relative;
        }
        .order-card:hover {
            transform: translateX(-6px);
            border-color: rgba(251,191,36,.4);
            box-shadow: -10px 0 30px -10px rgba(251,191,36,.3);
        }

        /* Status badges */
        .badge { padding:5px 14px; border-radius:999px; font-size:11px; font-weight:800; letter-spacing:.5px; text-transform:uppercase; }
        .badge-pending   { background: linear-gradient(135deg, rgba(251,191,36,.2), rgba(251,191,36,.08)); color:#fde047; border:1px solid rgba(251,191,36,.4); box-shadow: 0 0 15px rgba(251,191,36,.15); }
        .badge-accepted  { background: linear-gradient(135deg, rgba(96,165,250,.2), rgba(96,165,250,.08)); color:#bfdbfe; border:1px solid rgba(96,165,250,.4); box-shadow: 0 0 15px rgba(96,165,250,.15); }
        .badge-delivered { background: linear-gradient(135deg, rgba(52,211,153,.2), rgba(52,211,153,.08)); color:#a7f3d0; border:1px solid rgba(52,211,153,.4); box-shadow: 0 0 15px rgba(52,211,153,.15); }
        .badge-default   { background: rgba(148,163,184,.15); color:#e2e8f0; border:1px solid rgba(148,163,184,.3); }

        /* Custom select */
        .nice-select {
            background: rgba(15,23,42,.8);
            color:#f1f5f9 !important;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px; padding: 10px 16px;
            appearance:none; -webkit-appearance:none;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8' fill='none'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%23fbbf24' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: left 14px center; padding-left:38px;
            transition: all .3s;
        }
        .nice-select:focus { outline:none; border-color: var(--neon-y); box-shadow: 0 0 0 3px rgba(251,191,36,.15); }
        .nice-select option { background: #0a1229; color: #f1f5f9; }

        /* Gradient buttons */
        .btn-gold {
            background: linear-gradient(135deg, #fbbf24, #f97316);
            color: #1a0f00; font-weight: 900;
            padding: 10px 22px; border-radius: 12px;
            box-shadow: 0 10px 30px -10px rgba(251,191,36,.6), inset 0 1px 0 rgba(255,255,255,.3);
            transition: all .3s;
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 15px 35px -10px rgba(251,191,36,.8); }

        .btn-green {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; font-weight: 800;
            padding: 12px 24px; border-radius: 12px;
            box-shadow: 0 10px 30px -10px rgba(16,185,129,.6);
            transition: all .3s;
        }
        .btn-green:hover { transform: translateY(-2px); box-shadow: 0 15px 35px -10px rgba(16,185,129,.8); }

        .btn-danger {
            background: rgba(248,113,113,.1);
            color: #fca5a5; border:1px solid rgba(248,113,113,.3);
            font-weight:700; padding:10px; border-radius:10px;
            transition: all .3s; width:100%;
            display:flex; align-items:center; justify-content:center; gap:8px;
        }
        .btn-danger:hover { background: #ef4444; color:#fff; box-shadow: 0 10px 25px -10px rgba(239,68,68,.6); border-color:#ef4444; }

        /* Meal row */
        .meal-row {
            padding: 14px; border-radius: 14px;
            background: linear-gradient(135deg, rgba(255,255,255,.04), rgba(255,255,255,.01));
            border: 1px solid rgba(255,255,255,.05);
            transition: all .3s; cursor: default;
        }
        .meal-row:hover { border-color: rgba(251,191,36,.3); transform: translateX(-4px); }

        /* Animations */
        @keyframes fadeUp { from {opacity:0; transform:translateY(24px);} to {opacity:1; transform:translateY(0);} }
        .fade-up { animation: fadeUp .7s cubic-bezier(.2,.8,.2,1) forwards; opacity:0; }

        @keyframes slideInRight { from {transform:translateX(120%); opacity:0;} to {transform:translateX(0); opacity:1;} }
        .toast-anim { animation: slideInRight .5s cubic-bezier(.2,.8,.2,1); }

        .neon-text {
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 50%, #f472b6 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 20px rgba(251,191,36,.3));
        }

        /* Avatar letter */
        .avatar-letter {
            width: 56px; height: 56px; border-radius: 16px;
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-weight:900; font-size: 24px;
            font-family: 'Space Grotesk', sans-serif;
            box-shadow: 0 10px 25px -10px currentColor;
        }
    </style>

    <div class="dash min-h-screen p-6 md:p-10" style="background: radial-gradient(ellipse at top, #0a1229 0%, #050814 60%, #020409 100%);">

        {{-- ============ HEADER ============ --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12 fade-up">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-block w-10 h-[2px] bg-gradient-to-r from-yellow-400 to-transparent"></span>
                    <p class="text-yellow-400 text-xs font-black tracking-[.3em]">ADMIN • CONTROL PANEL</p>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight">
                    لوحة التحكم
                    <span class="neon-text">الرئيسية</span>
                </h1>
                <p class="text-slate-300 mt-3 text-lg">مرحباً بك 👋 — نظرة شاملة على أداء منصّتك</p>
            </div>
            <div class="glass-card px-5 py-3 mt-6 md:mt-0 flex items-center gap-3">
                <div class="relative">
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    <div class="absolute inset-0 w-3 h-3 rounded-full bg-green-400 animate-ping"></div>
                </div>
                <span class="text-slate-100 text-sm font-bold">LIVE • النظام يعمل الآن</span>
            </div>
        </div>

        {{-- ============ STATS GRID ============ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

            {{-- المبيعات --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#34d399; animation-delay:.05s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="pulse"></span>
                        <span class="text-xs font-black tracking-widest" style="color:#34d399">LIVE</span>
                    </div>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">💰 إجمالي المبيعات</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (float) $totalSales }}" data-testid="total-sales">{{ $totalSales }}</h2>
                <div class="progress-bar"><span style="--w:85%"></span></div>
            </div>

            {{-- عمولة التطبيق --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#f87171; animation-delay:.1s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <span class="text-xs font-black tracking-widest" style="color:#f87171">COMMISSION</span>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">💸 عمولة التطبيق</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (float) $commission }}" data-testid="commission">{{ $commission }}</h2>
                <div class="progress-bar"><span style="--w:60%"></span></div>
            </div>

            {{-- أرباح المطاعم --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#60a5fa; animation-delay:.15s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-black tracking-widest" style="color:#60a5fa">REVENUE</span>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">🏪 أرباح المطاعم</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (float) $restaurantsRevenue }}" data-testid="restaurants-revenue">{{ $restaurantsRevenue }}</h2>
                <div class="progress-bar"><span style="--w:72%"></span></div>
            </div>

            {{-- الطلبات --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#fbbf24; animation-delay:.2s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-xs font-black tracking-widest" style="color:#fbbf24">ORDERS</span>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">📦 عدد الطلبات</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (int) $totalOrders }}" data-testid="total-orders">{{ $totalOrders }}</h2>
                <div class="progress-bar"><span style="--w:92%"></span></div>
            </div>

            {{-- المستخدمين --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#a78bfa; animation-delay:.25s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-xs font-black tracking-widest" style="color:#a78bfa">USERS</span>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">👥 المستخدمين</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (int) $usersCount }}" data-testid="users-count">{{ $usersCount }}</h2>
                <div class="progress-bar"><span style="--w:78%"></span></div>
            </div>

            {{-- المطاعم --}}
            <div class="glass-card stat p-6 fade-up" style="--c:#fb923c; animation-delay:.3s">
                <div class="flex items-start justify-between mb-5">
                    <div class="icon-wrap">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-xs font-black tracking-widest" style="color:#fb923c">PARTNERS</span>
                </div>
                <p class="text-slate-300 text-sm font-semibold mb-2">🍔 المطاعم</p>
                <h2 class="text-4xl font-black text-white count-up" data-target="{{ (int) $restaurantsCount }}" data-testid="restaurants-count">{{ $restaurantsCount }}</h2>
                <div class="progress-bar"><span style="--w:65%"></span></div>
            </div>
        </div>

        {{-- ============ CHART + TOP MEALS ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <div class="lg:col-span-2 glass-card p-7 fade-up">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-1.5 h-6 bg-gradient-to-b from-yellow-400 to-orange-500 rounded-full"></span>
                            <h2 class="text-2xl font-black text-white">تحليل الإيرادات</h2>
                        </div>
                        <p class="text-slate-400 text-sm">نمو المبيعات عبر الزمن</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="flex items-center gap-1.5 text-slate-300"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> الإيرادات</span>
                    </div>
                </div>
                <canvas id="revenueChart" height="110"></canvas>
            </div>

            <div class="glass-card p-7 fade-up">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-1.5 h-6 bg-gradient-to-b from-pink-400 to-red-500 rounded-full"></span>
                    <h2 class="text-2xl font-black text-white">الأكثر مبيعاً</h2>
                </div>
                <p class="text-slate-400 text-sm mb-5">🔥 أفضل الوجبات أداءً</p>
                <div class="space-y-3">
                    @php $maxMeal = $topMeals->max('total') ?: 1; @endphp
                    @foreach($topMeals as $index => $meal)
                        @php
                            $medals = ['🥇','🥈','🥉'];
                            $medal = $medals[$index] ?? '⭐';
                            $colors = ['#fbbf24','#cbd5e1','#f97316'];
                            $color = $colors[$index] ?? '#a78bfa';
                            $percent = ($meal->total / $maxMeal) * 100;
                        @endphp
                        <div class="meal-row">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">{{ $medal }}</span>
                                    <div>
                                        <p class="text-white font-bold text-sm">Meal #{{ $meal->meal_id }}</p>
                                        <p class="text-slate-400 text-xs">وجبة رائجة</p>
                                    </div>
                                </div>
                                <span class="text-xl font-black" style="color:{{ $color }}">{{ $meal->total }}</span>
                            </div>
                            <div class="h-1.5 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $percent }}%; background: linear-gradient(90deg, {{ $color }}, {{ $color }}aa); box-shadow: 0 0 8px {{ $color }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ============ ORDERS ============ --}}
        <div class="glass-card p-7 mb-12 fade-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-blue-400 to-indigo-500 rounded-full"></span>
                        <h2 class="text-2xl font-black text-white">📋 الطلبات</h2>
                    </div>
                    <p class="text-slate-400 text-sm">قائمة بآخر الطلبات الواردة</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <select name="status" class="nice-select" data-testid="filter-status">
                        <option value="">كل الحالات</option>
                        <option value="pending">pending</option>
                        <option value="accepted">accepted</option>
                        <option value="delivered">delivered</option>
                    </select>
                    <button class="btn-gold" data-testid="filter-btn">
                        تطبيق الفلتر
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($orders as $order)
                    @php
                        $statusClass = match($order->status) {
                            'pending'   => 'badge-pending',
                            'accepted'  => 'badge-accepted',
                            'delivered' => 'badge-delivered',
                            default     => 'badge-default'
                        };
                    @endphp
                    <div class="order-card">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-slate-400 text-xs font-semibold mb-1">ORDER ID</p>
                                <p class="text-3xl font-black" style="font-family:'Space Grotesk'; background: linear-gradient(135deg,#fbbf24,#f97316); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;">#{{ $order->id }}</p>
                            </div>
                            <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-white/5">
                            <span class="text-slate-300 text-sm font-semibold">السعر النهائي</span>
                            <span class="text-white font-black text-xl">{{ $order->final_price }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <p class="text-lg font-bold">لا توجد طلبات حالياً</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ============ RESTAURANTS ============ --}}
        <div class="glass-card p-7 fade-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-1.5 h-6 bg-gradient-to-b from-orange-400 to-red-500 rounded-full"></span>
                        <h2 class="text-2xl font-black text-white">🍽️ إدارة المطاعم</h2>
                    </div>
                    <p class="text-slate-400 text-sm">إضافة، عرض وحذف المطاعم المسجّلة</p>
                </div>
                <a href="/admin/restaurants/create" class="btn-green" data-testid="add-restaurant">
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        إضافة مطعم
                    </span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @php
                    $avatarGradients = [
                        'linear-gradient(135deg,#fb923c,#ef4444)',
                        'linear-gradient(135deg,#a78bfa,#6366f1)',
                        'linear-gradient(135deg,#34d399,#059669)',
                        'linear-gradient(135deg,#f472b6,#db2777)',
                        'linear-gradient(135deg,#fbbf24,#f59e0b)',
                        'linear-gradient(135deg,#60a5fa,#2563eb)',
                    ];
                @endphp
                @foreach($restaurants as $i => $restaurant)
                    <div class="glass-card p-5 hover:border-yellow-400/40 transition" style="border-radius:16px;">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="avatar-letter" style="background: {{ $avatarGradients[$i % count($avatarGradients)] }}">
                                {{ mb_strtoupper(mb_substr($restaurant->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-slate-400 text-xs font-semibold mb-0.5">RESTAURANT</p>
                                <p class="text-white font-bold truncate">{{ $restaurant->name }}</p>
                            </div>
                        </div>
                        <form method="POST" action="/admin/restaurants/{{ $restaurant->id }}"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المطعم؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" data-testid="delete-restaurant-{{ $restaurant->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 7V4a1 1 0 011-1h2a1 1 0 011 1v3"/></svg>
                                <span>حذف المطعم</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Footer signature --}}
        <div class="text-center mt-12 text-slate-500 text-xs">
            <p>Dashboard v2 · مبني بـ Laravel + Tailwind · Real-time via Pusher ⚡</p>
        </div>
    </div>

    {{-- ============ TOAST CONTAINER ============ --}}
    <div id="toast-container" class="fixed top-6 left-6 z-[9999] space-y-3"></div>

    {{-- ============ SCRIPTS ============ --}}
    <script>
        // Counter animation
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
                else el.textContent = isInt ? Math.floor(target).toLocaleString() : target.toFixed(2);
            }
            requestAnimationFrame(tick);
        });

        // Pusher
        Pusher.logToConsole = true;
        const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
        });
        const channel = pusher.subscribe('orders-channel');

       function showToast(msg) {
    const t = document.createElement('div');

    t.innerText = '🔔 ' + msg;

    t.style.position = 'fixed';
    t.style.top = '20px';
    t.style.left = '20px';
    t.style.background = '#22c55e';
    t.style.color = 'white';
    t.style.padding = '15px';
    t.style.borderRadius = '10px';
    t.style.zIndex = '999999';

    document.body.appendChild(t);

    setTimeout(() => t.remove(), 4000);
}

       channel.bind('NewOrderEvent', function(data) {

    showToast('طلب جديد #' + data.order_id);

    // تحديث عدد الطلبات
    const el = document.querySelector('[data-testid="total-orders"]');
    if (el) {
        let current = parseInt(el.innerText.replace(/,/g, '')) || 0;
        el.innerText = current + 1;
    }

    // 🔴 تحديث Badge
    const badge = document.getElementById('notif-count');
    if (badge) {
        let count = parseInt(badge.innerText) || 0;
        badge.innerText = count + 1;
    }

});

        // Chart
        const chartDataRaw = @json($chartData);
        const labels = chartDataRaw.map(i => i.date);
        const totals = chartDataRaw.map(i => i.total);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        const grad = ctx.createLinearGradient(0, 0, 0, 320);
        grad.addColorStop(0, 'rgba(251,191,36,0.55)');
        grad.addColorStop(0.5, 'rgba(249,115,22,0.25)');
        grad.addColorStop(1, 'rgba(251,191,36,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'الإيرادات',
                    data: totals,
                    borderColor: '#fbbf24',
                    backgroundColor: grad,
                    borderWidth: 3,
                    tension: 0.45,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f97316',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 10,
                    pointHoverBackgroundColor: '#f97316',
                    pointHoverBorderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(10,18,41,.95)',
                        titleColor: '#fbbf24',
                        bodyColor: '#f1f5f9',
                        borderColor: 'rgba(251,191,36,.3)',
                        borderWidth: 1,
                        padding: 14,
                        titleFont: { family: 'Cairo', weight: 'bold', size: 14 },
                        bodyFont: { family: 'Cairo', size: 13 },
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8', font: { family: 'Cairo', weight: '600' } }, grid: { color: 'rgba(255,255,255,.04)', drawBorder: false } },
                    y: { ticks: { color: '#94a3b8', font: { family: 'Cairo', weight: '600' } }, grid: { color: 'rgba(255,255,255,.04)', drawBorder: false } }
                }
            }
        });
    </script>
</x-app-layout>