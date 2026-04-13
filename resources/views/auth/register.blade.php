<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jisajili | ELLYPESA</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .bg-primary { background-color: #FF6F00; }
        .text-primary { color: #FF6F00; }
        .hover\:bg-primary-dark:hover { background-color: #E65100; }

        .toast {
            transition: all 0.4s ease;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 h-screen flex items-center justify-center p-2 overflow-hidden">

<!-- TOAST -->
<div id="toast" class="toast fixed top-5 left-1/2 transform -translate-x-1/2 z-50 hidden">
    <div class="bg-black text-white px-5 py-3 rounded-xl shadow-lg text-sm flex items-center gap-2">
        <i class="fas fa-info-circle text-orange-400"></i>
        <span id="toast-message"></span>
    </div>
</div>

<div class="w-full max-w-sm">

    <!-- HEADER (compact) -->
    <div class="text-center mb-3">
        <a href="{{ route('landing') }}" class="text-3xl font-extrabold text-primary tracking-wide">
            ELLYPESA
        </a>
        <p class="text-gray-600 text-xs mt-1">Jisajili kwenye akaunti yako</p>
    </div>

    <!-- CARD (very compact) -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-4 border border-gray-100">

        <!-- ERRORS -->
        @if ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    showToast("{{ $errors->first() }}");
                });
            </script>
        @endif

        <!-- SUCCESS -->
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    showToast("{{ session('success') }}");
                });
            </script>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            <!-- JINA KAMILI -->
            <div>
                <label class="text-xs text-gray-700 font-medium">Jina Kamili</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full mt-0.5 px-3 py-2 text-sm rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="Mh. Jina M. Kamili">
            </div>

            <!-- BARUA PEPE -->
            <div>
                <label class="text-xs text-gray-700 font-medium">
                    Barua Pepe <span class="text-gray-400">(si lazima)</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full mt-0.5 px-3 py-2 text-sm rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="mpenzi@example.com">
            </div>

            <!-- NAMBA YA SIMU -->
            <div>
                <label class="text-xs text-gray-700 font-medium">Namba ya Simu</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                       class="w-full mt-0.5 px-3 py-2 text-sm rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="07XXXXXXXX au 06XXXXXXXX">
            </div>

            <!-- NYWILA -->
            <div>
                <label class="text-xs text-gray-700 font-medium">Nywila</label>
                <input type="password" name="password" required
                       class="w-full mt-0.5 px-3 py-2 text-sm rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="••••••••">
            </div>

            <!-- THIBITISHA NYWILA -->
            <div>
                <label class="text-xs text-gray-700 font-medium">Thibitisha Nywila</label>
                <input type="password" name="password_confirmation" required
                       class="w-full mt-0.5 px-3 py-2 text-sm rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="••••••••">
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white text-sm font-bold py-2 rounded-lg shadow-md transition active:scale-95 mt-1">
                👉 JISAJILI
            </button>
        </form>

        <!-- LOGIN LINK -->
        <div class="mt-3 text-center text-xs text-gray-600">
            Tayari una akaunti?
            <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">
                Ingia hapa
            </a>
        </div>
    </div>

    <!-- BACK LINK -->
    <div class="mt-2 text-center text-gray-500 text-xs">
        <a href="{{ route('landing') }}" class="hover:text-primary">
            <i class="fas fa-arrow-left mr-1"></i> Rudi nyuma
        </a>
    </div>
</div>

<!-- TOAST SCRIPT -->
<script>
    function showToast(message) {
        const toast = document.getElementById("toast");
        const msg = document.getElementById("toast-message");

        msg.innerText = message;
        toast.classList.remove("hidden");

        setTimeout(() => {
            toast.classList.add("opacity-0");

            setTimeout(() => {
                toast.classList.add("hidden");
                toast.classList.remove("opacity-0");
            }, 300);

        }, 2000);
    }
</script>

</body>
</html>