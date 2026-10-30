<?php

use App\Models\Animal;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('menampilkan halaman utama dengan daftar satwa', function () {
    Animal::factory()->create([
        'title' => 'Kucing Persia Putih',
    ]);

    $response = $this->get(route('animals.index'));

    $response->assertOk();
    $response->assertSee('Kucing Persia Putih');
});

test('berhasil menyimpan pendaftaran satwa ke database', function () {
    $payload = [
        'type' => 'lost',
        'title' => 'Milo Kucing Oren',
        'species' => 'kucing',
        'district' => 'Wonokromo, Surabaya',
        'contact_phone' => '081234567890',
        'email' => 'pelapor@example.com',
        'description' => 'Kucing oren hilang di sekitar pasar Joyoboyo dengan kalung biru.',
        'reward_or_fee' => 'Rp 500.000',
        'identification_code' => 'CHIP-99881',
    ];

    $response = $this->post(route('animals.store'), $payload);

    $response->assertRedirect(route('animals.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('animals', [
        'title' => 'Milo Kucing Oren',
        'type' => 'lost',
        'species' => 'kucing',
        'district' => 'Wonokromo, Surabaya',
        'contact_phone' => '081234567890',
        'email' => 'pelapor@example.com',
        'identification_code' => 'CHIP-99881',
    ]);
});

test('berhasil menyimpan pendaftaran satwa beserta file foto', function () {
    Storage::fake('public');

    $photo = UploadedFile::fake()->image('satwa.jpg');

    $payload = [
        'type' => 'lost',
        'title' => 'Burung Parkit Australia',
        'species' => 'burung',
        'district' => 'Gubeng, Surabaya',
        'contact_phone' => '089876543210',
        'email' => 'parkit@example.com',
        'description' => 'Lepas saat latihan di area terbuka.',
        'photo' => $photo,
    ];

    $response = $this->post(route('animals.store'), $payload);

    $response->assertRedirect(route('animals.index'));

    $animal = Animal::where('title', 'Burung Parkit Australia')->first();
    expect($animal)->not->toBeNull();
    expect($animal->photo_path)->not->toBeNull();
    expect($animal->email)->toBe('parkit@example.com');

    Storage::disk('public')->assertExists($animal->photo_path);
});

test('validasi gagal jika field wajib tidak diisi', function () {
    $response = $this->post(route('animals.store'), []);

    $response->assertSessionHasErrors([
        'title',
        'species',
        'district',
        'contact_phone',
        'email',
        'description',
    ]);

    $this->assertDatabaseCount('animals', 0);
});

test('berhasil menyimpan pendaftaran satwa dengan pilihan kota dan alamat detail serta sanitasi', function () {
    $payload = [
        'reporter_name' => '<b>Bayu Wicaksono</b>',
        'title' => '<b>Kucing Persia Abu</b>',
        'species' => 'kucing',
        'city' => 'Sidoarjo',
        'address_detail' => 'Kecamatan Waru, Jalan Melati No. 4',
        'contact_phone' => '081234567899',
        'email' => 'persia@example.com',
        'description' => '<script>alert("xss")</script>Kucing abu-abu lepas dari pagar rumah.',
        'reward_or_fee' => '1000000',
    ];

    $response = $this->post(route('animals.store'), $payload);

    $response->assertRedirect(route('animals.index'));
    $response->assertSessionHas('success');

    $animal = Animal::where('email', 'persia@example.com')->first();
    expect($animal)->not->toBeNull();
    expect($animal->reporter_name)->toBe('Bayu Wicaksono');
    expect($animal->title)->toBe('Kucing Persia Abu');
    expect($animal->description)->not->toContain('<script>');
    expect($animal->city)->toBe('Sidoarjo');
    expect($animal->address_detail)->toBe('Kecamatan Waru, Jalan Melati No. 4');
    expect($animal->reward_or_fee)->toBe('Rp 1.000.000');
});

test('foto tidak hilang ketika validasi form mengalami error', function () {
    Storage::fake('public');

    $photo = UploadedFile::fake()->image('kucing_oren.jpg');

    // Missing required fields (e.g. description and email) to trigger validation error
    $payload = [
        'title' => 'Milo Oren',
        'species' => 'kucing',
        'city' => 'Surabaya',
        'address_detail' => 'Rungkut',
        'contact_phone' => '08123456789',
        'photo' => $photo,
    ];

    $response = $this->post(route('animals.store'), $payload);

    $response->assertSessionHasErrors(['email', 'description']);
    $response->assertSessionHas('temp_photo_path');

    $tempPath = session('temp_photo_path');
    expect($tempPath)->not->toBeNull();
    Storage::disk('public')->assertExists($tempPath);
});
