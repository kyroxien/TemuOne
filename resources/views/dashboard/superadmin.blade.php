<x-layouts.app :title="__('Super Admin Dashboard – Lost & Found')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Top Stats -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <!-- Total Laporan -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Total Laporan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Total Penemuan -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Penemuan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Total Kehilangan -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Kehilangan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- User Summary -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-3 mt-4">
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Jumlah User</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Jumlah Admin</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Jumlah Super Admin</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- Additional Content Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-blue-200 bg-blue-50 shadow-sm p-6 mt-4">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Konten Manajemen Lost & Found</h2>
            <ul class="space-y-2 text-blue-800">
                <li>• Kelola seluruh laporan kehilangan</li>
                <li>• Kelola laporan penemuan</li>
                <li>• Validasi laporan sebelum dipublikasikan</li>
                <li>• Manajemen user system</li>
                <li>• Riwayat laporan dan audit trail</li>
                <li>• Statistik dan grafik laporan bulanan</li>
            </ul>
        </div>
    </div>
</x-layouts.app>

