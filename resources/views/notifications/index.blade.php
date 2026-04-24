<x-app-layout>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');
    .notif-page * { font-family: 'Tajawal', sans-serif; }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeInUp 0.4s ease forwards; }
    .unread-bar { background: linear-gradient(to left, #f97316, #facc15, #f97316); }
    .btn-accept { background: #10b981; transition: all 0.2s; }
    .btn-accept:hover { background: #059669; transform: scale(1.02); }
    .btn-reject { background: white; color: #ef4444; border: 2px solid #fecaca; transition: all 0.2s; }
    .btn-reject:hover { background: #fef2f2; border-color: #f87171; }
</style>

<div class="notif-page min-h-screen" style="background: #fafaf9;" dir="rtl">

    <div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
        <div style="position:absolute;top:-100px;right:-100px;width:500px;height:500px;border-radius:50%;background:rgba(249,115,22,0.05);filter:blur(60px);"></div>
        <div style="position:absolute;bottom:-100px;left:-100px;width:400px;height:400px;border-radius:50%;background:rgba(250,204,21,0.05);filter:blur(60px);"></div>
    </div>

    <div style="position:relative;z-index:1;" class="max-w-2xl mx-auto px-4 py-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div style="width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,#f97316,#facc15);display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(249,115,22,0.3);">
                    🔔
                </div>
                <div>
                    <h1 style="font-size:1.75rem;font-weight:900;color:#1c1917;line-height:1.2;">الإشعارات</h1>
                    <p style="font-size:0.8rem;color:#78716c;margin-top:2px;">
                        {{ $notifications->count() }} إشعار
                        @php $unread = $notifications->filter(fn($n) => is_null($n->read_at))->count(); @endphp
                        @if($unread > 0)
                            &nbsp;•&nbsp;<span style="color:#f97316;font-weight:700;">{{ $unread }} جديد</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($unread > 0)
            <form method="POST" action="{{ url('/notifications/mark-all-read') }}">
                @csrf
                <button type="submit" style="display:flex;align-items:center;gap:6px;font-size:0.8rem;color:#78716c;background:none;border:none;cursor:pointer;padding:8px 12px;border-radius:10px;transition:all 0.2s;" onmouseover="this.style.color='#f97316';this.style.background='#fff7ed'" onmouseout="this.style.color='#78716c';this.style.background='none'">
                    ✓✓ تحديد الكل كمقروء
                </button>
            </form>
            @endif
        </div>

        {{-- STATS --}}
        @php
            $allOrders = $notifications->map(function($n) {
                $id = $n->data['order_id'] ?? null;
                return $id ? \App\Models\Order::find($id) : null;
            })->filter();
            $pendingCount  = $allOrders->where('status','pending')->count();
            $acceptedCount = $allOrders->where('status','accepted')->count();
            $rejectedCount = $allOrders->where('status','rejected')->count();
        @endphp

        @if($notifications->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:28px;">
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:16px;padding:16px;position:relative;overflow:hidden;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                    <span>⏳</span>
                    <span style="font-size:0.7rem;font-weight:600;color:#78716c;">قيد الانتظار</span>
                </div>
                <p style="font-size:1.75rem;font-weight:900;color:#d97706;">{{ $pendingCount }}</p>
            </div>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:16px;padding:16px;position:relative;overflow:hidden;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                    <span>✅</span>
                    <span style="font-size:0.7rem;font-weight:600;color:#78716c;">مقبول</span>
                </div>
                <p style="font-size:1.75rem;font-weight:900;color:#16a34a;">{{ $acceptedCount }}</p>
            </div>
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:16px;padding:16px;position:relative;overflow:hidden;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                    <span>❌</span>
                    <span style="font-size:0.7rem;font-weight:600;color:#78716c;">مرفوض</span>
                </div>
                <p style="font-size:1.75rem;font-weight:900;color:#dc2626;">{{ $rejectedCount }}</p>
            </div>
        </div>
        @endif

        {{-- LIST --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

        @forelse($notifications as $i => $notification)
            @php
                $orderId = $notification->data['order_id'] ?? null;
                $order = \App\Models\Order::with('user')->find($orderId);
                $isUnread = is_null($notification->read_at);
                $delay = $i * 80;
            @endphp

            <div class="animate-fade-in" style="animation-delay: {{ $delay }}ms; opacity:0;">

                {{-- البطاقة كلها رابط يودي على orders.show --}}
                <a href="{{ route('orders.show', $orderId) }}" style="text-decoration:none;display:block;">
                    <div class="card-hover" style="
                        background: white;
                        border-radius: 20px;
                        border: 1px solid {{ $isUnread ? 'rgba(249,115,22,0.2)' : '#e7e5e4' }};
                        overflow: hidden;
                        box-shadow: {{ $isUnread ? '0 8px 30px rgba(249,115,22,0.08)' : '0 2px 10px rgba(0,0,0,0.04)' }};
                    ">
                        @if($isUnread)
                        <div class="unread-bar" style="height:3px;width:100%;"></div>
                        @endif

                        <div style="padding:20px 24px;">
                            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div style="width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#f97316,#facc15);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.1rem;">
                                        📦
                                    </div>
                                    <div>
                                        <h3 style="font-weight:800;color:#1c1917;font-size:1rem;">
                                            🚀 طلب جديد #{{ $orderId }}
                                        </h3>
                                        <p style="font-size:0.75rem;color:#a8a29e;margin-top:2px;">
                                            🕐 {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                @if($order)
                                <span style="
                                    flex-shrink:0;padding:4px 14px;border-radius:99px;font-size:0.7rem;font-weight:700;border:1.5px solid;
                                    {{ $order->status == 'pending'  ? 'background:#fffbeb;color:#92400e;border-color:#fde68a;' : '' }}
                                    {{ $order->status == 'accepted' ? 'background:#f0fdf4;color:#166534;border-color:#bbf7d0;' : '' }}
                                    {{ $order->status == 'rejected' ? 'background:#fff1f2;color:#991b1b;border-color:#fecdd3;' : '' }}
                                ">
                                    {{ $order->status == 'pending' ? 'قيد الانتظار' : ($order->status == 'accepted' ? '✓ مقبول' : '✗ مرفوض') }}
                                </span>
                                @endif
                            </div>

                            @if($order)
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                                <div style="background:#f9fafb;border-radius:14px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:10px;background:#fff7ed;display:flex;align-items:center;justify-content:center;font-size:0.9rem;">💰</div>
                                    <div>
                                        <p style="font-size:0.65rem;color:#78716c;font-weight:600;">السعر</p>
                                        <p style="font-weight:800;color:#1c1917;font-size:0.9rem;">{{ $order->final_price }} ر.س</p>
                                    </div>
                                </div>
                                <div style="background:#f9fafb;border-radius:14px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:10px;background:#fefce8;display:flex;align-items:center;justify-content:center;font-size:0.9rem;">👤</div>
                                    <div>
                                        <p style="font-size:0.65rem;color:#78716c;font-weight:600;">العميل</p>
                                        <p style="font-weight:800;color:#1c1917;font-size:0.9rem;">{{ $order->user->name ?? '---' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>

                {{-- أزرار القبول والرفض خارج الرابط --}}
                @if($order && $order->status == 'pending')
                <div style="display:flex;gap:10px;margin-top:10px;">
                    <form method="POST" action="{{ route('orders.accept', $order->id) }}" style="flex:1;">
                        @csrf
                        <button type="submit" class="btn-accept" style="width:100%;color:white;padding:11px;border-radius:12px;font-weight:700;font-size:0.875rem;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                            ✅ قبول الطلب
                        </button>
                    </form>
                    <form method="POST" action="{{ route('orders.reject', $order->id) }}" style="flex:1;">
                        @csrf
                        <button type="submit" class="btn-reject" style="width:100%;padding:11px;border-radius:12px;font-weight:700;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                            ❌ رفض الطلب
                        </button>
                    </form>
                </div>
                @endif

            </div>

        @empty
            <div style="text-align:center;padding:80px 20px;">
                <div style="width:72px;height:72px;border-radius:50%;background:#f5f5f4;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:2rem;">🔕</div>
                <h3 style="font-size:1.125rem;font-weight:700;color:#1c1917;margin-bottom:6px;">لا يوجد إشعارات</h3>
                <p style="color:#78716c;font-size:0.875rem;">سيتم إعلامك هنا عند وصول طلبات جديدة</p>
            </div>
        @endforelse

        </div>
    </div>
</div>

</x-app-layout>