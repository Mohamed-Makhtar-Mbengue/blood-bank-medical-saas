<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blood Bank</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <!-- 🌗 FIX GLOBAL TABLEAUX + FILTRES -->
    <style>
        /* TABLEAU GLOBAL */
        table {
            @apply w-full border-collapse rounded-xl overflow-hidden;
        }

        thead {
            @apply bg-blue-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200;
        }

        th {
            @apply px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600;
        }

        tbody tr {
            @apply bg-white dark:bg-gray-800;
        }

        tbody tr:nth-child(even) {
            @apply bg-blue-50 dark:bg-gray-700;
        }

        td {
            @apply px-4 py-3 border-b border-blue-100 dark:border-gray-700
                   text-gray-700 dark:text-gray-300;
        }

        /* FILTRES */
        input, select {
            @apply bg-white dark:bg-gray-800
                   text-gray-700 dark:text-gray-200
                   border border-blue-200 dark:border-gray-600
                   rounded-lg px-3 py-2
                   focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-600
                   transition;
        }

        .filter-btn {
            @apply bg-blue-600 dark:bg-blue-500
                   text-white font-medium
                   px-4 py-2 rounded-lg
                   hover:bg-blue-700 dark:hover:bg-blue-400
                   transition;
        }
    </style>

    <!-- 🌗 SCRIPT MODE SOMBRE -->
    <script>
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleTheme() {
            const html = document.documentElement;

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</head>

<body class="transition-colors duration-300 min-h-screen font-sans text-gray-700
    bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200
    dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-gray-200">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 flex flex-col
        bg-white/70 dark:bg-gray-800/70
        backdrop-blur-xl
        border-r border-blue-100 dark:border-gray-700
        shadow-lg">

        <!-- Logo + Thème -->
        <div class="p-6 border-b border-blue-100 dark:border-gray-700 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-8 h-8 text-blue-600 dark:text-blue-300"
                     fill="currentColor"
                     viewBox="0 0 24 24">
                    <path d="M12 2c-2.5 3.5-5 6.7-5 9.5a5 5 0 0 0 10 0c0-2.8-2.5-6-5-9.5z"/>
                </svg>

                <span class="text-xl font-bold text-blue-700 dark:text-blue-300">
                    Blood Bank
                </span>
            </div>

            <!-- Bouton Thème -->
            <button onclick="toggleTheme()"
                    class="p-2 rounded-full bg-white/70 dark:bg-gray-700 shadow hover:scale-110 transition">

                <!-- Soleil -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-yellow-500 block dark:hidden"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v2m0 14v2m9-9h-2M5 12H3
                             m15.364 6.364l-1.414-1.414M7.05 7.05L5.636 5.636
                             m12.728 0l-1.414 1.414M7.05 16.95l-1.414 1.414
                             M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>

                <!-- Lune -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-blue-300 hidden dark:block"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646
                             9.001 9.001 0 0020.354 15.354z"/>
                </svg>

            </button>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 p-6 space-y-3">

            <a href="{{ route('emergencies.index') }}"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-blue-100 dark:hover:bg-gray-700 transition">
                🩸 Urgences
            </a>

            <a href="{{ route('inventory.index') }}"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-blue-100 dark:hover:bg-gray-700 transition">
                📦 Stock
            </a>

            <a href="{{ route('donations.index') }}"
               class="flex items-center gap-3 p-3 rounded-xl
                      hover:bg-blue-100 dark:hover:bg-gray-700 transition">
                👥 Donneurs
            </a>

            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}" class="pt-6">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 p-3 w-full rounded-xl
                               text-red-600 dark:text-red-300
                               hover:bg-red-100 dark:hover:bg-red-800 transition">

                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M3 4a1 1 0 011-1h6a1 1 0 110 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm11.293
                                 5.293a1 1 0 010 1.414L12.414 13l1.879 1.879a1 1 0 11-1.414
                                 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                              clip-rule="evenodd"/>
                    </svg>

                    <span class="font-medium">Déconnexion</span>
                </button>
            </form>

        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER MOBILE -->
        <header class="md:hidden
            bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl
            border-b border-blue-100 dark:border-gray-700
            p-4 flex items-center justify-between">

            <span class="font-bold text-blue-700 dark:text-blue-300">
                Blood Bank
            </span>

            <button onclick="toggleTheme()"
                    class="p-2 rounded-full bg-white/70 dark:bg-gray-700 shadow hover:scale-105 transition">

                <!-- Soleil -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-yellow-500 block dark:hidden"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v2m0 14v2m9-9h-2M5
                             12H3m15.364 6.364l-1.414-1.414M7.05
                             7.05L5.636 5.636m12.728 0l-1.414
                             1.414M7.05 16.95l-1.414 1.414
                             M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>

                <!-- Lune -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-blue-300 hidden dark:block"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646
                             3.646 9.001 9.001 0 0020.354 15.354z"/>
                </svg>

            </button>
        </header>

        <!-- CONTENU -->
        <main class="flex-1 p-4 sm:p-6 lg:p-10">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
