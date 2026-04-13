@extends('layouts.app')

@section('title', 'Lipa - ' . $skill->name)
@section('page-title', 'Malipo')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Lipa kwa {{ $skill->name }}</h2>
        <p class="text-gray-600 text-sm mb-6">Kiasi: <span class="font-bold text-primary">Tsh {{ number_format($skill->price) }}</span></p>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-800 mb-2">Maelekezo ya Malipo:</h3>
            <p class="text-sm text-gray-600">1. Piga *150*00# au tumia app ya benki</p>
            <p class="text-sm text-gray-600">2. Lipia namba: <strong>0678 043 562</strong> (ELLYPESA)</p>
            <p class="text-sm text-gray-600">3. Weka namba ya kumbukumbu (transaction ID) hapa chini</p>
        </div>
        
        <form action="{{ route('user.payment.store', $skill) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Njia ya Malipo</label>
                <select name="payment_method" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="mobile_money">M-Pesa / Tigo Pesa / Airtel Money</option>
                    <option value="bank_transfer">Benki</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Namba ya Kumbukumbu (Transaction ID)</label>
                <input type="text" name="transaction_id" required class="w-full px-4 py-2 border rounded-lg" placeholder="mf: MP123456789">
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 rounded-lg transition">
                Thibitisha Malipo
            </button>
        </form>
        
        <p class="text-xs text-gray-500 mt-4 text-center">Admin atathibitisha malipo yako na utapata ufikiaji mara moja.</p>
    </div>
</div>
@endsection