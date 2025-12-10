<x-layouts.app :title="__('Admin Dashboard – Lost & Found')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Top Stats -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <!-- Total Laporan Dikelola -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Total Laporan Dikelola</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Laporan Kehilangan -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Kehilangan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Laporan Penemuan -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Penemuan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- Progress & Validation Section -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 mt-4">
            <!-- Laporan Menunggu Validasi -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Menunggu Validasi</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Laporan Selesai Diproses -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Selesai</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- Additional Content Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-blue-200 bg-blue-50 shadow-sm p-6 mt-4">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Fungsi Admin Lost & Found</h2>
            <ul class="space-y-2 text-blue-800">
                <li>• Memverifikasi laporan kehilangan</li>
                <li>• Memverifikasi laporan penemuan</li>
                <li>• Menghubungi pelapor jika diperlukan</li>
                <li>• Mengelola status laporan (pending, valid, selesai)</li>
                <li>• Mengatur kategori barang hilang/temuan</li>
                <li>• Melihat riwayat laporan yang pernah ditangani</li>
            </ul>
        </div>
    </div>
</x-layouts.app>