<div class="max-w-6xl mx-auto bg-white/30 backdrop-blur-xl shadow-xl rounded-2xl p-6 border border-blue-100">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-blue-50/60 text-blue-700 uppercase text-xs">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
