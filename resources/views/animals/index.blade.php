@extends('layouts.app')

@section('content')
@php
    $animals = (isset($animals) && count($animals) > 0) ? $animals : collect([
        [
            'id' => 1, 'type' => 'lost', 'reporter_name' => 'Rizky Ramadhan', 'title' => 'Simba',
            'city' => 'Surabaya', 'address_detail' => 'Jalan Dharmawangsa No. 28, Gubeng', 'district' => 'Gubeng', 'district_label' => 'Jalan Dharmawangsa No. 28, Gubeng, Surabaya',
            'species' => 'kucing', 'radius_km' => 2,
            'description' => 'Kucing persia mix jantan warna cokelat krem, bulu lebat, ekor agak pendek. Terakhir terlihat bermain di teras depan rumah.',
            'reward_or_fee' => 'Rp 500.000', 'code' => 'Kalung Kulit Cokelat', 'phone' => '081234567891',
            'photo_url' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=85',
            'time_label' => '20 menit lalu',
        ],
        [
            'id' => 2, 'type' => 'lost', 'reporter_name' => 'Jessica Tanuwidjaja', 'title' => 'Bruno',
            'city' => 'Surabaya', 'address_detail' => 'Citraland Northwest Lake, Sambikerep', 'district' => 'Sambikerep', 'district_label' => 'Citraland Northwest Lake, Sambikerep, Surabaya',
            'species' => 'anjing', 'radius_km' => 3,
            'description' => 'Golden retriever jantan usia 2 tahun, warna pirang emas, sangat ramah pada manusia. Memakai kalung nilon warna merah.',
            'reward_or_fee' => 'Rp 2.000.000', 'code' => 'Microchip ID: 98514100234', 'phone' => '081398765432',
            'photo_url' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=85',
            'time_label' => '1 jam lalu',
        ],
        [
            'id' => 3, 'type' => 'lost', 'reporter_name' => 'Hendro Wibowo', 'title' => 'Chiko',
            'city' => 'Sidoarjo', 'address_detail' => 'Pondok Jati Blok AS No. 12, Sidoarjo', 'district' => 'Sidoarjo', 'district_label' => 'Pondok Jati Blok AS No. 12, Sidoarjo, Sidoarjo',
            'species' => 'burung', 'radius_km' => 4,
            'description' => 'Burung kakatua putih jambul kuning, jinak bisa bersiul dan memanggil nama sendiri. Terlepas saat jemur kandang pagi hari.',
            'reward_or_fee' => 'Rp 1.000.000', 'code' => 'Ring Kuningan BKSDA-JK-092', 'phone' => '082155667788',
            'photo_url' => 'https://images.unsplash.com/photo-1544943910-4c1dc44a0b38?auto=format&fit=crop&w=600&q=85',
            'time_label' => '3 jam lalu',
        ],
        [
            'id' => 4, 'type' => 'lost', 'reporter_name' => 'Anisa Rahmawati', 'title' => 'Koko',
            'city' => 'Malang', 'address_detail' => 'Perumahan Sulfat Garden Kav 4, Blimbing', 'district' => 'Blimbing', 'district_label' => 'Perumahan Sulfat Garden Kav 4, Blimbing, Malang',
            'species' => 'lainnya', 'radius_km' => 1,
            'description' => 'Sugar glider jantan warna abu-abu corak hitam, sangat jinak suka tidur di pouch kantong kain. Loncat keluar saat membuka jendela balkon.',
            'reward_or_fee' => 'Rp 350.000', 'code' => 'Pouch Beludru Biru', 'phone' => '087811223344',
            'photo_url' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=600&q=85',
            'time_label' => '5 jam lalu',
        ],
        [
            'id' => 5, 'type' => 'lost', 'reporter_name' => 'Dimas Kurniawan', 'title' => 'Oreo',
            'city' => 'Gresik', 'address_detail' => 'Jalan Dr. Wahidin Sudirohusodo No. 14, Kebomas', 'district' => 'Kebomas', 'district_label' => 'Jalan Dr. Wahidin Sudirohusodo No. 14, Kebomas, Gresik',
            'species' => 'kucing', 'radius_km' => 2,
            'description' => 'Kucing betina corak 3 warna (hitam, putih, oranye), telinga kiri ada bekas goresan kecil sembuh. Memakai kalung pita motif polkadot.',
            'reward_or_fee' => 'Rp 250.000', 'code' => 'Kalung Lonceng Kecil', 'phone' => '085699887766',
            'photo_url' => null,
            'time_label' => '8 jam lalu',
        ],
        [
            'id' => 6, 'type' => 'lost', 'reporter_name' => 'Maya Kartika', 'title' => 'Bella',
            'city' => 'Surabaya', 'address_detail' => 'Kertajaya Indah Timur XI No. 8, Mulyorejo', 'district' => 'Mulyorejo', 'district_label' => 'Kertajaya Indah Timur XI No. 8, Mulyorejo, Surabaya',
            'species' => 'anjing', 'radius_km' => 2,
            'description' => 'Anjing toy poodle betina bulu keriting mengembang warna apricot pirang kemerahan. Pemalu dan takut dengan suara motor bising.',
            'reward_or_fee' => 'Rp 1.500.000', 'code' => 'Kalung Pink Liontin Tulang', 'phone' => '081299001122',
            'photo_url' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=600&q=85',
            'time_label' => '1 hari lalu',
        ],
    ])->map(fn ($a) => is_array($a) ? (object) $a : $a);
@endphp

<!-- Flash Success Notification -->
@if (session('success'))
    <div class="mt-4 flex items-center justify-between gap-3 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-900 shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="h-5 w-5 shrink-0 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="22 4 12 14.01 9 11.01" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p class="text-xs sm:text-sm font-normal text-emerald-900">{{ session('success') }}</p>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-950 font-medium" aria-label="Tutup notifikasi">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
@endif

<!-- ==================== VIEW: JELAJAH SATWA HILANG ==================== -->
<section id="view-marketplace" class="relative">

    <!-- Sticky Hero Header (Ketimpa mulus saat discroll) -->
    <div class="sticky top-[62px] z-0 pb-6 pt-4 sm:pt-6 bg-satwa-bg">
        @include('animals.partials.hero')
    </div>

    <!-- Sliding Sheet Content (Warna latar menyatu tanpa batas aneh) -->
    <div class="relative z-10 bg-satwa-bg pt-3 space-y-4 min-h-[70vh]">

        <!-- Filter Component -->
        @include('animals.partials.filters')

        <!-- Dedicated Row for Result Count -->
        <div class="flex items-center px-1 pt-1 pb-1">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-satwa-forest"></span>
                <span id="result-count" class="text-xs font-medium text-satwa-forest">
                    Menampilkan 0 laporan satwa hilang
                </span>
            </div>
        </div>

        <!-- 2-Column Responsive Animal Cards Grid with Identical Heights -->
        <div id="cards-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">
            @forelse ($animals as $animal)
                @include('animals.partials.card', ['animal' => $animal, 'index' => $loop->index])
            @empty
                {{-- Empty state handled by client or fallback --}}
            @endforelse

            <!-- Empty State -->
            <div id="empty-state" class="col-span-full panel hidden px-5 py-12 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-satwa-sand text-satwa-forest">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m16 16 4 4" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="mt-4 font-heading text-base font-semibold text-satwa-forest">Tidak ada satwa yang cocok</h3>
                <p class="mt-1.5 text-xs text-satwa-muted">Coba ubah kata kunci atau sesuaikan filter lokasi.</p>
                <button onclick="resetFilters()" class="secondary-btn mt-4">Reset Pencarian</button>
            </div>
        </div>

    </div>

</section>

<!-- ==================== VIEW: FORM BUAT LAPORAN ==================== -->
@include('animals.partials.report-form')

@endsection
