<x-layouts.app :title="__('User Dashboard – Lost & Found')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        <!-- Section: Ringkasan Laporan User -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <!-- Total Laporan Saya -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Saya</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Laporan Kehilangan Saya -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Kehilangan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Laporan Penemuan Saya -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Penemuan</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- Section: Status Detail -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 mt-4">
            <!-- Status Pending -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Pending</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>

            <!-- Status Selesai -->
            <div class="p-6 rounded-xl border border-blue-200 bg-blue-50 shadow-sm">
                <h2 class="text-lg font-semibold text-blue-900">Laporan Selesai</h2>
                <p class="text-4xl font-bold text-blue-700 mt-2">0</p>
            </div>
        </div>

        <!-- Section: Fitur User -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-blue-200 bg-blue-50 shadow-sm p-6 mt-4">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Fungsi Pengguna Lost & Found</h2>
            <ul class="space-y-2 text-blue-800">
                <li>• Membuat laporan kehilangan barang</li>
                <li>• Membuat laporan penemuan barang</li>
                <li>• Melacak perkembangan laporan</li>
                <li>• Mengunggah foto barang hilang/temuan</li>
                <li>• Mengedit atau memperbarui laporan yang belum divalidasi</li>
                <li>• Melihat riwayat seluruh laporan pribadi</li>
            </ul>
        </div>

    </div>
</x-layouts.app>
