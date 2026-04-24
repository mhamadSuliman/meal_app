<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');

* { font-family: 'Cairo', sans-serif; }

:root{
    --orange1:#ff6b35;
    --orange2:#f7931e;
    --dark:#0f0f0f;
}

/* ================= ANIMATIONS ================= */
@keyframes fadeUp {
    from {opacity:0; transform:translateY(30px);}
    to {opacity:1; transform:translateY(0);}
}

@keyframes float {
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-10px)}
}

@keyframes glow {
    0%,100%{box-shadow:0 0 20px rgba(255,107,53,.2)}
    50%{box-shadow:0 0 40px rgba(255,107,53,.5)}
}

/* ================= BACKGROUND ================= */
.bg-blur {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
}

.orb {
    position:absolute;
    border-radius:50%;
    filter: blur(80px);
    opacity:.25;
}

.orb1{width:500px;height:500px;background:var(--orange1);top:-120px;right:-120px;}
.orb2{width:400px;height:400px;background:var(--orange2);bottom:-120px;left:-120px;}
.orb3{width:300px;height:300px;background:#ff3d3d;top:40%;left:40%;}

/* ================= GLASS ================= */
.glass {
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,.3);
}

/* ================= CARD ================= */
.card {
    transition:.35s ease;
    transform-style: preserve-3d;
}

.card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0,0,0,.12);
}

/* ================= BUTTON ================= */
.btn {
    background: linear-gradient(135deg,var(--orange1),var(--orange2));
    color:white;
    padding:10px 16px;
    border-radius:12px;
    font-weight:700;
    transition:.3s;
}

.btn:hover {
    transform: translateY(-2px);
}

/* ================= EMPTY STATE ================= */
.empty {
    text-align:center;
    padding:80px 20px;
    color:#888;
}
</style>

<div class="bg-blur">
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
</div>

<div class="relative z-10 min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50">

{{-- ================= HEADER ================= --}}
<div class="max-w-6xl mx-auto px-6 pt-10">

    <div class="flex justify-between items-center mb-10">

        <div>
            <h1 class="text-3xl font-black text-gray-900">🍽️ المطاعم</h1>
            <p class="text-gray-500 text-sm">إدارة وفلترة المطاعم حسب المدينة</p>
        </div>

        <a href="/admin/restaurants/create" class="btn">
            + إضافة مطعم
        </a>

    </div>

{{-- ================= FILTER ================= --}}
<form method="GET" class="glass p-4 rounded-2xl flex flex-wrap gap-3 items-center shadow-sm">

    <select name="city_id"
        class="px-4 py-2 rounded-xl border bg-white min-w-[200px]">

        <option value="">كل المدن</option>

        @foreach($cities as $city)
            <option value="{{ $city->id }}"
                {{ request('city_id') == $city->id ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
        @endforeach

    </select>

    <button class="btn">
        فلترة
    </button>

    <a href="/restaurants" class="text-sm text-gray-500 hover:text-black">
        إعادة تعيين
    </a>

</form>

</div>

{{-- ================= GRID ================= --}}
<div class="max-w-6xl mx-auto px-6 mt-10">

@if($restaurants->count())

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($restaurants as $i => $restaurant)

<a href="/restaurants/{{ $restaurant->id }}" class="block">

<div class="card glass rounded-3xl overflow-hidden p-5" style="animation:fadeUp .4s ease forwards; animation-delay:{{ $i*80 }}ms; opacity:0;">

    {{-- TOP --}}
    <div class="flex justify-between items-center mb-4">

        <div class="text-xs px-3 py-1 rounded-full bg-orange-100 text-orange-600 font-bold">
            #{{ $i+1 }}
        </div>

        <div class="text-xs text-gray-400">
            ⭐ {{ $restaurant->rating ?? '4.5' }}
        </div>

    </div>

    {{-- TITLE --}}
    <h2 class="text-xl font-black text-gray-900 mb-2">
        {{ $restaurant->name }}
    </h2>

    <p class="text-sm text-gray-500 mb-5 line-clamp-2">
        {{ $restaurant->description ?? 'مطعم مميز يقدم تجربة طعام رائعة' }}
    </p>

    {{-- FOOTER --}}
    <div class="flex justify-between items-center">

        <span class="text-orange-500 font-bold text-sm">
            عرض التفاصيل →
        </span>

        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white">
            🍴
        </div>

    </div>

</div>

</a>

@endforeach

</div>

@else

<div class="empty">
    <h2 class="text-xl font-bold">لا توجد مطاعم</h2>
    <p>جرّب تغيير المدينة أو إضافة مطاعم جديدة</p>
</div>

@endif

</div>

</div>

</x-app-layout>