<x-app-layout>

<style>
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');

* { font-family: 'Tajawal', sans-serif; }

:root{
    --bg:#0b0b0f;
    --card:rgba(255,255,255,0.06);
    --stroke:rgba(255,255,255,0.08);
    --orange:#ff7a18;
}

/* BACKGROUND */
.bg {
    position:fixed;
    inset:0;
    background: radial-gradient(circle at top left, #1a1a22, var(--bg));
    z-index:0;
    overflow:hidden;
}

.glow {
    position:absolute;
    width:600px;
    height:600px;
    border-radius:50%;
    filter: blur(120px);
    opacity:.25;
}

.g1{background:var(--orange); top:-200px; right:-200px;}
.g2{background:#ff3d81; bottom:-200px; left:-200px;}

/* CARD */
.card {
    background: var(--card);
    border:1px solid var(--stroke);
    backdrop-filter: blur(18px);
}

/* INPUT */
.input {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 10px 12px;
    border-radius: 12px;
    outline: none;
}

.input:focus {
    border-color: var(--orange);
}

/* BUTTON */
.btn {
    background: linear-gradient(135deg, #ff7a18, #ff3d81);
    color:white;
    font-weight:700;
    padding:10px 16px;
    border-radius:14px;
}
</style>

<div class="bg">
    <div class="glow g1"></div>
    <div class="glow g2"></div>
</div>

<div class="relative z-10 min-h-screen text-white">

{{-- HERO --}}
<div class="max-w-6xl mx-auto px-6 pt-14 pb-10">

    <a href="{{ url('/restaurants') }}"
   class="text-white/50 hover:text-white text-sm">
    ← العودة للمطاعم
</a>

    <div class="card rounded-3xl p-8 mt-6 flex justify-between items-center">

        <div>
            <h1 class="text-4xl font-black">{{ $restaurant->name }}</h1>
            <p class="text-white/50 mt-2">
                {{ $restaurant->description }}
            </p>
        </div>

        <div class="text-center">
            <div class="text-4xl text-orange-400 font-black">
                {{ $restaurant->meals->count() }}
            </div>
            <div class="text-xs text-white/40">Meals</div>
        </div>

    </div>
</div>

{{-- ADD MEAL --}}
<div class="max-w-6xl mx-auto px-6 mb-10">

    <div class="card p-6 rounded-3xl">

        <h2 class="text-xl font-black mb-4">➕ إضافة وجبة</h2>

        <form method="POST" action="/restaurants/{{ $restaurant->id }}/meals"
              class="grid md:grid-cols-4 gap-3">

            @csrf

            <input name="name" class="input" placeholder="اسم الوجبة" required>

            <input name="price" class="input" placeholder="السعر" required>

            <input name="description" class="input" placeholder="الوصف">

            <!-- 👇 TYPE FIX -->
            <select name="type" class="input" required>
                <option value="">نوع الوجبة</option>
                <option value="food">Food</option>
                <option value="drink">Drink</option>
                <option value="dessert">Dessert</option>
            </select>

            <button class="btn md:col-span-4">
                إضافة
            </button>

        </form>

    </div>
</div>

{{-- MEALS --}}
<div class="max-w-6xl mx-auto px-6 pb-20">

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($restaurant->meals as $meal)

        <div class="card p-5 rounded-2xl">

            <h3 class="text-xl font-black">{{ $meal->name }}</h3>

            <p class="text-white/50 text-sm">
                {{ $meal->description }}
            </p>

            <div class="text-orange-400 font-black mt-2">
                {{ $meal->price }} $
            </div>

            <div class="text-xs text-white/40 mt-1">
                Type: {{ $meal->type }}
            </div>

            <div class="flex gap-2 mt-4">

                {{-- DELETE --}}
                <form method="POST" action="/meals/{{ $meal->id }}">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 px-3 py-1 rounded-lg text-sm">
                        حذف
                    </button>
                </form>

                {{-- EDIT --}}
                <button onclick="document.getElementById('edit-{{ $meal->id }}').classList.toggle('hidden')"
                        class="bg-blue-500 px-3 py-1 rounded-lg text-sm">
                    تعديل
                </button>

            </div>

            {{-- EDIT FORM --}}
            <form id="edit-{{ $meal->id }}" method="POST"
                  action="/meals/{{ $meal->id }}"
                  class="hidden mt-4 grid gap-2">

                @csrf
                @method('PUT')

                <input name="name" value="{{ $meal->name }}" class="input">

                <input name="price" value="{{ $meal->price }}" class="input">

                <input name="description" value="{{ $meal->description }}" class="input">

                <!-- 👇 IMPORTANT TYPE EDIT -->
                <select name="type" class="input">
                    <option value="food" {{ $meal->type=='food'?'selected':'' }}>Food</option>
                    <option value="drink" {{ $meal->type=='drink'?'selected':'' }}>Drink</option>
                    <option value="dessert" {{ $meal->type=='dessert'?'selected':'' }}>Dessert</option>
                </select>

                <button class="btn">
                    حفظ
                </button>

            </form>

        </div>

    @endforeach

    </div>
</div>

</div>

</x-app-layout>