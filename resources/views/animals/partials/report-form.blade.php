@php
    $persistedPhotoPath = session('temp_photo_path', old('temp_photo_path'));
@endphp

<section id="view-report" class="hidden space-y-6 pt-8">

    <div>
        <h1 class="font-heading text-3xl font-semibold leading-tight text-satwa-forest sm:text-4xl">Buat Laporan Satwa Hilang</h1>
        <p class="mt-2 max-w-xl text-sm leading-relaxed text-satwa-muted">Lengkapi formulir di bawah ini agar informasi peliharaan Anda segera tercatat dan dapat dipantau oleh warga sekitar.</p>
    </div>

    <div class="mx-auto max-w-3xl">
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-rose-300 bg-rose-50 p-4 text-rose-900 shadow-sm">
                <div class="flex items-center gap-2 font-medium">
                    <svg class="h-5 w-5 text-rose-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>Periksa kembali data yang Anda masukkan:</span>
                </div>
                <ul class="mt-2 list-inside list-disc text-xs space-y-1 text-rose-800">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="report-animal-form" action="{{ route('animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden field for preserving uploaded photo across validation errors -->
            <input type="hidden" name="temp_photo_path" id="temp_photo_path" value="{{ $persistedPhotoPath }}">
            <input type="hidden" name="type" value="lost">

            <div class="panel overflow-hidden shadow-sm">
                <div class="border-b border-satwa-line px-5 py-5 sm:px-7 bg-satwa-bg/30">
                    <h2 class="font-heading text-lg font-semibold text-satwa-forest">Formulir Pencarian Satwa</h2>
                    <p class="mt-1 text-xs text-satwa-muted">Data ini akan dipublikasikan ke papan informasi warga dan bukti tanda terima dikirimkan ke email Anda.</p>
                </div>

                <div class="space-y-6 px-5 py-6 sm:px-7">

                    <!-- 1. Data Pelapor (Diletakkan di Paling Atas Sesuai Permintaan) -->
                    <div>
                        <h3 class="font-heading text-base font-semibold text-satwa-forest">Data Pelapor / Pemilik Satwa</h3>
                        <p class="mt-0.5 text-xs text-satwa-muted">Informasi kontak Anda agar warga yang menemukan satwa dapat segera menghubungi.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-3">
                            <label for="reporter_name" class="field-label">Nama Anda (Pelapor) *</label>
                            <input id="reporter_name" type="text" name="reporter_name" value="{{ old('reporter_name') }}" required maxlength="150" class="field" placeholder="Nama lengkap atau nama panggilan Anda">
                            @error('reporter_name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-1">
                            <label for="contact_phone" class="field-label">Nomor WhatsApp *</label>
                            <input id="contact_phone" type="tel" name="contact_phone" value="{{ old('contact_phone') }}" required maxlength="25" class="field" placeholder="08xxxxxxxxxx">
                            @error('contact_phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="field-label">Email Pelapor (Untuk Bukti Tanda Terima) *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" class="field" placeholder="nama@email.com">
                            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-satwa-line"></div>

                    <!-- 2. Identitas Satwa -->
                    <div>
                        <h3 class="font-heading text-base font-semibold text-satwa-forest">Identitas Satwa Hilang</h3>
                        <p class="mt-0.5 text-xs text-satwa-muted">Informasi ciri dasar peliharaan yang hilang.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="title" class="field-label">Nama Satwa *</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" required maxlength="150" class="field" placeholder="Contoh: Mochi, Milo, Snowy">
                            @error('title') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="species" class="field-label">Kategori Spesies *</label>
                            <div class="relative">
                                <select id="species" name="species" required class="field !h-11 !pr-9 text-xs sm:text-sm appearance-none cursor-pointer">
                                    <option value="">Pilih kategori spesies</option>
                                    <option value="kucing" {{ old('species') === 'kucing' ? 'selected' : '' }}>Kucing</option>
                                    <option value="anjing" {{ old('species') === 'anjing' ? 'selected' : '' }}>Anjing</option>
                                    <option value="burung" {{ old('species') === 'burung' ? 'selected' : '' }}>Burung</option>
                                    <option value="reptil" {{ old('species') === 'reptil' ? 'selected' : '' }}>Reptil</option>
                                    <option value="mamalia" {{ old('species') === 'mamalia' ? 'selected' : '' }}>Mamalia kecil</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-satwa-muted">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            @error('species') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="identification_code" class="field-label">Ring ID / Kalung / Microchip</label>
                            <input id="identification_code" type="text" name="identification_code" value="{{ old('identification_code') }}" maxlength="100" class="field" placeholder="Nomor kalung atau tanda khusus jika ada">
                            @error('identification_code') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="reward_or_fee" class="field-label">Imbalan Bagi Penemu dalam Rupiah</label>
                            <div class="relative flex items-center">
                                <span class="pointer-events-none absolute left-3.5 text-xs font-semibold text-satwa-forest">Rp</span>
                                <input id="reward_or_fee" type="text" name="reward_or_fee" value="{{ old('reward_or_fee') }}" maxlength="50" class="field !pl-10" placeholder="500.000">
                            </div>
                            @error('reward_or_fee') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-satwa-line"></div>

                    <!-- 3. Lokasi dan Kronologi -->
                    <div>
                        <h3 class="font-heading text-base font-semibold text-satwa-forest">Lokasi Terakhir & Kronologi Hilang</h3>
                        <p class="mt-0.5 text-xs text-satwa-muted">Tentukan kota dan alamat spesifik tempat satwa terakhir terlihat.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="city" class="field-label">Kota Wilayah *</label>
                            <div class="relative">
                                <select id="city" name="city" required class="field !h-11 !pr-9 text-xs sm:text-sm appearance-none cursor-pointer">
                                    <option value="Surabaya" {{ old('city', 'Surabaya') === 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                                    <option value="Sidoarjo" {{ old('city') === 'Sidoarjo' ? 'selected' : '' }}>Sidoarjo</option>
                                    <option value="Gresik" {{ old('city') === 'Gresik' ? 'selected' : '' }}>Gresik</option>
                                    <option value="Malang" {{ old('city') === 'Malang' ? 'selected' : '' }}>Malang</option>
                                    <option value="Mojokerto" {{ old('city') === 'Mojokerto' ? 'selected' : '' }}>Mojokerto</option>
                                    <option value="Pasuruan" {{ old('city') === 'Pasuruan' ? 'selected' : '' }}>Pasuruan</option>
                                    <option value="Batu" {{ old('city') === 'Batu' ? 'selected' : '' }}>Batu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-satwa-muted">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            @error('city') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="address_detail" class="field-label">Detail Alamat / Area Hilang *</label>
                            <input id="address_detail" type="text" name="address_detail" value="{{ old('address_detail', old('district')) }}" required maxlength="255" class="field" placeholder="Kecamatan, nama jalan, atau patokan terdekat">
                            @error('address_detail') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="field-label">Ciri Fisik dan Kronologi Hilang *</label>
                            <textarea id="description" name="description" required maxlength="5000" rows="4" class="field resize-y" placeholder="Jelaskan warna bulu, corak, kepribadian jinak/takut, tanggal atau jam kejadian hilang...">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="border-t border-satwa-line"></div>

                    <!-- 4. Foto Satwa dengan Image Preview & Error Retention -->
                    <div>
                        <h3 class="font-heading text-base font-semibold text-satwa-forest">Foto Satwa Peliharaan</h3>
                        <p class="mt-0.5 text-xs text-satwa-muted">Unggah foto jelas satwa Anda agar mudah dikenali saat warga berpatroli.</p>
                    </div>

                    <label for="photo" class="upload-zone flex cursor-pointer flex-col items-center justify-center p-6 text-center">
                        <div id="photo-preview-container" class="{{ $persistedPhotoPath ? '' : 'hidden' }} mb-3">
                            <img id="photo-preview" src="{{ $persistedPhotoPath ? asset('storage/' . $persistedPhotoPath) : '#' }}" alt="Preview Foto Satwa" class="max-h-48 w-auto rounded-xl object-contain shadow-sm border border-satwa-line mx-auto">
                        </div>

                        <div id="photo-default-ui" class="{{ $persistedPhotoPath ? 'hidden' : 'flex' }} flex-col items-center">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-satwa-softgreen text-satwa-olive">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                                    <circle cx="8.5" cy="9" r="1.5"/>
                                    <path d="m21 15-5-5L5 20" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="mt-3 text-xs font-semibold text-satwa-forest">Klik untuk memilih foto satwa</span>
                        </div>

                        <span id="photo-name" class="mt-1 text-xs text-satwa-muted">
                            {{ $persistedPhotoPath ? 'Foto tersimpan dan siap dikirim (klik untuk mengganti)' : 'Format: JPG, PNG, atau WebP (Maksimal 5 MB)' }}
                        </span>
                        <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="handlePhotoChange(this)">
                    </label>
                    @error('photo') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror

                    <!-- Submit Button with Active Loading State -->
                    <button id="report-submit-btn" type="submit" class="primary-btn w-full py-3 text-sm">
                        Kirim Laporan Peliharaan Hilang
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
