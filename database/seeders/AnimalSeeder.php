<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals = [
            [
                'type' => 'lost',
                'reporter_name' => 'Rizky Ramadhan',
                'title' => 'Simba',
                'species' => 'kucing',
                'city' => 'Surabaya',
                'address_detail' => 'Jalan Dharmawangsa No. 28, Gubeng',
                'district' => 'Gubeng',
                'district_label' => 'Jalan Dharmawangsa No. 28, Gubeng, Surabaya',
                'radius_km' => 2,
                'description' => 'Kucing persia mix jantan warna cokelat krem, bulu lebat, ekor agak pendek. Terakhir terlihat bermain di teras depan rumah.',
                'reward_or_fee' => 'Rp 500.000',
                'identification_code' => 'Kalung Kulit Cokelat',
                'contact_phone' => '081234567891',
                'email' => 'rizky.ramadhan@gmail.com',
                'photo_path' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=85',
                'map_x' => 35,
                'map_y' => 28,
            ],
            [
                'type' => 'lost',
                'reporter_name' => 'Jessica Tanuwidjaja',
                'title' => 'Bruno',
                'species' => 'anjing',
                'city' => 'Surabaya',
                'address_detail' => 'Citraland Northwest Lake, Sambikerep',
                'district' => 'Sambikerep',
                'district_label' => 'Citraland Northwest Lake, Sambikerep, Surabaya',
                'radius_km' => 3,
                'description' => 'Golden retriever jantan usia 2 tahun, warna pirang emas, sangat ramah pada manusia. Memakai kalung nilon warna merah.',
                'reward_or_fee' => 'Rp 2.000.000',
                'identification_code' => 'Microchip ID: 98514100234',
                'contact_phone' => '081398765432',
                'email' => 'jessica.tan@gmail.com',
                'photo_path' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=85',
                'map_x' => 25,
                'map_y' => 45,
            ],
            [
                'type' => 'lost',
                'reporter_name' => 'Hendro Wibowo',
                'title' => 'Chiko',
                'species' => 'burung',
                'city' => 'Sidoarjo',
                'address_detail' => 'Jalan Raya Taman Asri No. 12, Waru',
                'district' => 'Waru',
                'district_label' => 'Jalan Raya Taman Asri No. 12, Waru, Sidoarjo',
                'radius_km' => 4,
                'description' => 'Bulu putih bersih dengan jambul kuning cerah di kepala. Bisa menirukan suara siulan dan terlepas dari sangkar saat dibersihkan.',
                'reward_or_fee' => 'Rp 1.000.000',
                'identification_code' => 'Ring Kaki: BKSDA-SDA-441',
                'contact_phone' => '082155667788',
                'email' => 'hendro.wibowo@gmail.com',
                'photo_path' => 'https://images.unsplash.com/photo-1555169062-013468b47731?auto=format&fit=crop&w=600&q=85',
                'map_x' => 60,
                'map_y' => 68,
            ],
            [
                'type' => 'lost',
                'reporter_name' => 'Anisa Rahmawati',
                'title' => 'Koko',
                'species' => 'mamalia',
                'city' => 'Malang',
                'address_detail' => 'Jalan Soekarno Hatta No. 45, Lowokwaru',
                'district' => 'Lowokwaru',
                'district_label' => 'Jalan Soekarno Hatta No. 45, Lowokwaru, Malang',
                'radius_km' => 1,
                'description' => 'Sugar glider classic grey jantan usia 8 bulan, jinak di kantong kain. Hilang di sekitar area kos putri.',
                'reward_or_fee' => 'Rp 350.000',
                'identification_code' => 'Tidak ada tanda',
                'contact_phone' => '081700998811',
                'email' => 'anisa.rahma@gmail.com',
                'photo_path' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=600&q=85',
                'map_x' => 70,
                'map_y' => 80,
            ],
            [
                'type' => 'lost',
                'reporter_name' => 'Dimas Kurniawan',
                'title' => 'Oreo',
                'species' => 'kucing',
                'city' => 'Gresik',
                'address_detail' => 'Perumahan GKB Blok F, Manyar',
                'district' => 'Manyar',
                'district_label' => 'Perumahan GKB Blok F, Manyar, Gresik',
                'radius_km' => 2,
                'description' => 'Kucing betina calico (belang tiga: hitam, putih, oranye). Sifat pemalu dan takut suara bising kendaraan bermotor.',
                'reward_or_fee' => 'Rp 250.000',
                'identification_code' => 'Telinga Kiri Ada Tanda Steril',
                'contact_phone' => '085611223344',
                'email' => 'dimas.kurniawan@gmail.com',
                'photo_path' => null, // Tampil dengan placeholder logo SatwaTrace
                'map_x' => 18,
                'map_y' => 22,
            ],
            [
                'type' => 'lost',
                'reporter_name' => 'Maya Kartika',
                'title' => 'Bella',
                'species' => 'anjing',
                'city' => 'Surabaya',
                'address_detail' => 'Jalan Darmo Permai Selatan No. 8, Sukomanunggal',
                'district' => 'Sukomanunggal',
                'district_label' => 'Jalan Darmo Permai Selatan No. 8, Sukomanunggal, Surabaya',
                'radius_km' => 2,
                'description' => 'Toy poodle bulu putih keriting rapi, bertubuh kecil, terlepas saat pintu gerbang rumah dibuka untuk mobil masuk.',
                'reward_or_fee' => 'Rp 1.500.000',
                'identification_code' => 'Kalung Pita Merah Muda',
                'contact_phone' => '081822334455',
                'email' => 'maya.kartika@gmail.com',
                'photo_path' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?auto=format&fit=crop&w=600&q=85',
                'map_x' => 30,
                'map_y' => 50,
            ],
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
