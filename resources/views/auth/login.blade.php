<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingia | ELLYPESA</title>

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

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen flex items-center justify-center p-4">

<!-- TOAST -->
<div id="toast" class="toast fixed top-5 left-1/2 transform -translate-x-1/2 z-50 hidden">
    <div class="bg-black text-white px-5 py-3 rounded-xl shadow-lg text-sm flex items-center gap-2">
        <i class="fas fa-info-circle text-orange-400"></i>
        <span id="toast-message"></span>
    </div>
</div>

<div class="w-full max-w-sm">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <a href="{{ route('landing') }}" class="text-4xl font-extrabold text-primary tracking-wide">
            ELLYPESA
        </a>
        <p class="text-gray-600 text-sm mt-2">Ingia kwenye akaunti yako</p>
    </div>

    <!-- CARD -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-5 border border-gray-100">

        <!-- ERRORS -->
        @if ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    showToast("{{ $errors->first() }}", "error");
                });
            </script>
        @endif

        <!-- SUCCESS -->
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    showToast("{{ session('success') }}", "success");
                });
            </script>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- LOGIN -->
            <div>
                <label class="text-sm text-gray-700 font-medium">
                    Barua Pepe au Namba ya Simu
                </label>
                <input type="text" name="login" value="{{ old('login') }}" required
                       class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="amina@example.com au 07XXXXXXXX">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="text-sm text-gray-700 font-medium">Nywila</label>
                <input type="password" name="password" required
                       class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 outline-none transition"
                       placeholder="••••••••">
            </div>

            <!-- REMEMBER -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember"
                           class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    Nikumbuke
                </label>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 rounded-xl shadow-lg transition active:scale-95">
                👉 INGIA
            </button>
        </form>

        <!-- REGISTER LINK -->
        <div class="mt-5 text-center text-sm">
            <p class="text-gray-600">
                Huna akaunti?
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                    Jisajili hapa
                </a>
            </p>
        </div>
    </div>

    <!-- BACK -->
    <div class="mt-5 text-center text-gray-500 text-sm">
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