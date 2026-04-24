<x-app-layout>

<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12">

<div class="max-w-3xl mx-auto px-6">

<div class="bg-white rounded-3xl shadow-xl p-8">

<h1 class="text-3xl font-black mb-6">✏️ تعديل المطعم</h1>

<form method="POST" action="/restaurants/{{ $restaurant->id }}">
@csrf
@method('PUT')

<div class="mb-4">
<label>اسم المطعم</label>
<input name="name" value="{{ $restaurant->name }}" class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>المدينة</label>
<select name="city_id" class="w-full border p-2 rounded">
@foreach($cities as $city)
<option value="{{ $city->id }}"
{{ $restaurant->city_id == $city->id ? 'selected' : '' }}>
{{ $city->name }}
</option>
@endforeach
</select>
</div>

<div class="mb-4">
<label>المالك</label>
<select name="user_id" class="w-full border p-2 rounded">
@foreach($owners as $owner)
<option value="{{ $owner->id }}"
{{ $restaurant->user_id == $owner->id ? 'selected' : '' }}>
{{ $owner->name }}
</option>
@endforeach
</select>
</div>

<button class="bg-orange-500 text-white px-6 py-2 rounded">
حفظ
</button>

</form>

</div>

</div>

</div>

</x-app-layout>