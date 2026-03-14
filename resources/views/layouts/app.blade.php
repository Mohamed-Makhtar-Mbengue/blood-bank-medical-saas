<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <title>Blood Bank</title>

    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />


    @vite(['resources/css/app.css','resources/js/app.js'])
    
</head>

<body class="min-h-screen font-sans text-gray-700
             bg-linear-to-br from-blue-50 via-blue-100 to-blue-200">

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 min-h-screen bg-white/70 backdrop-blur-xl 
                       border-r border-blue-100 shadow-lg">

            <!-- Logo -->
            <div class="p-6 border-b border-blue-100">
                <div class="flex items-center gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-8 h-8 text-blue-600"
                         viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M12 2c-2.5 3.5-5 6.7-5 9.5a5 5 0 0 0 10 0c0-2.8-2.5-6-5-9.5z"/>
                    </svg>

                    <span class="text-xl font-bold text-blue-700">
                        Blood Bank
                    </span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-6 space-y-3">

                <a href="{{ route('emergencies.index') }}"
                   class="block p-3 rounded-xl hover:bg-blue-100 transition font-medium">
                    🩸 Urgences
                </a>

                <a href="{{ route('inventory.index') }}"
                   class="block p-3 rounded-xl hover:bg-blue-100 transition font-medium">
                    🧊 Stock
                </a>

                <a href="{{ route('donations.index') }}"
                   class="block p-3 rounded-xl hover:bg-blue-100 transition font-medium">
                    👥 Donneurs
                </a>

            </nav>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            @yield('content')
        </main>

    </div>

</body>
</html>
