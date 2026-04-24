<x-app-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');
    .order-page * { font-family: 'Tajawal', sans-serif; }

    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

    .status-badge {
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1.5px solid;
    }

    .btn-accept { background: #10b981; transition: all 0.2s; }
    .btn-accept:hover { background: #059669; transform: scale(1.02); }

    .btn-reject { background: white; color: #ef4444; border: 2px solid #fecaca; transition: all 0.2s; }
    .btn-reject:hover { background: #fef2f2; border-color: #f87171; }
</style>

<div class="order-page min-h-screen" style="background:#fafaf9;" dir="rtl">

    <!-- خلفية حلوة -->
    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;">
        <div style="position:absolute;top:-100px;right:-100px;width:500px;height:500px;border-radius:50%;background:rgba(249,115,22,0.05);filter:blur(60px);"></div>
        <div style="position:absolute;bottom:-100px;left:-100px;width:400px;height:400px;border-radius:50%;background:rgba(250,204,21,0.05);filter:blur(60px);"></div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-8 relative z-10">

        <!-- HEADER -->
        <div class="flex items-center gap-3 mb-8">
            <div style="width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,#f97316,#facc15);display:flex;align-items:center;justify-content:center;">
                📦
            </div>
            <div>
                <h1 style="font-size:1.6rem;font-weight:900;">
                    تفاصيل الطلب #{{ $order->id }}
                </h1>
                <p style="font-size:0.8rem;color:#78716c;">
                    {{ $order->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <!-- CARD INFO -->
        <div class="card-hover bg-white rounded-2xl p-6 shadow mb-6">

            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-lg">📋 معلومات الطلب</h2>

                <span class="status-badge
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-700 border-yellow-300
                    @elseif($order->status == 'accepted') bg-green-100 text-green-700 border-green-300
                    @elseif($order->status == 'rejected') bg-red-100 text-red-700 border-red-300
                    @endif
                ">
                    {{ $order->status }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-3 text-sm">

                <div class="bg-gray-50 p-3 rounded-xl">
                    👤 <strong>المستخدم:</strong> {{ $order->user->name }}
                </div>

                <div class="bg-gray-50 p-3 rounded-xl">
                    📍 <strong>العنوان:</strong> {{ $order->address }}
                </div>

                <div class="bg-gray-50 p-3 rounded-xl">
                    📞 <strong>الهاتف:</strong> {{ $order->phone }}
                </div>

                <div class="bg-gray-50 p-3 rounded-xl">
                    💰 <strong>السعر النهائي:</strong> {{ $order->final_price }} ر.س
                </div>

            </div>

        </div>

        <!-- ITEMS -->
        <h2 class="text-xl font-bold mb-4">🍔 عناصر الطلب</h2>

        <div class="flex flex-col gap-3 mb-6">
            @foreach($order->items as $item)
                <div class="card-hover bg-white p-4 rounded-xl shadow">

                    <div class="flex justify-between items-center">
                        <p class="font-bold">
                            {{ $item->meal->name }}
                        </p>
                        <span class="text-sm text-gray-500">
                            × {{ $item->quantity }}
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mt-1">
                        السعر: {{ $item->price }} ر.س
                    </p>

                </div>
            @endforeach
        </div>

        <!-- ACTIONS -->
        @if($order->status == 'pending')
        <div class="flex gap-3">
            <form method="POST" action="{{ route('orders.accept', $order->id) }}" style="flex:1;">
                @csrf
                <button class="btn-accept w-full text-white py-3 rounded-xl font-bold">
                    ✅ قبول الطلب
                </button>
            </form>

            <form method="POST" action="{{ route('orders.reject', $order->id) }}" style="flex:1;">
                @csrf
                <button class="btn-reject w-full py-3 rounded-xl font-bold">
                    ❌ رفض الطلب
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

</x-app-layout>