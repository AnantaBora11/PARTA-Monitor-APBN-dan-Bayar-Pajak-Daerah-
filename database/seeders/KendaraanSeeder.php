<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Kendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 1234 YK'],
            [
                'nomor_rangka' => 'MHF1234567890111',
                'nomor_mesin' => 'E1234567',
                'merk' => 'Toyota',
                'tipe_model' => 'Avanza Veloz',
                'tahun_pembuatan' => 2021,
                'warna' => 'Hitam Metalik',
                'jenis_kendaraan' => 'Mobil',
                'nama_pemilik' => 'Sutrisno',
                'alamat_pemilik' => 'Jl. Kaliurang Km 5, Sleman, Yogyakarta',
            ]
        );

        \App\Models\PajakKendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 1234 YK', 'tahun_pajak' => 2025],
            [
                'tanggal_jatuh_tempo' => '2025-05-20',
                'jumlah_pajak' => 3500000,
                'status_pembayaran' => 'Lunas',
                'tanggal_bayar' => '2025-05-15',
                'denda' => 0,
            ]
        );

        // 2. Unpaid Vehicle (Lambat / Late)
        \App\Models\Kendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 4567 CD'],
            [
                'nomor_rangka' => 'MHF0987654321222',
                'nomor_mesin' => 'E7654321',
                'merk' => 'Honda',
                'tipe_model' => 'Beat Street',
                'tahun_pembuatan' => 2023,
                'warna' => 'Silver',
                'jenis_kendaraan' => 'Motor',
                'nama_pemilik' => 'Siti Aminah',
                'alamat_pemilik' => 'Jl. Parangtritis Km 10, Bantul, Yogyakarta',
            ]
        );

        \App\Models\PajakKendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 4567 CD', 'tahun_pajak' => 2025],
            [
                'tanggal_jatuh_tempo' => '2025-01-15',
                'jumlah_pajak' => 350000,
                'status_pembayaran' => 'Belum Bayar',
                'tanggal_bayar' => null,
                'denda' => 0,
            ]
        );

        // 3. Unpaid Vehicle (Future / Not Late)
        \App\Models\Kendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 8888 XX'],
            [
                'nomor_rangka' => 'MHF1122334455666',
                'nomor_mesin' => 'E1122334',
                'merk' => 'Mitsubishi',
                'tipe_model' => 'Pajero Sport',
                'tahun_pembuatan' => 2024,
                'warna' => 'Putih Mutiara',
                'jenis_kendaraan' => 'Mobil',
                'nama_pemilik' => 'Budi Santoso',
                'alamat_pemilik' => 'Perumahan Casa Grande, Depok, Sleman',
            ]
        );

        \App\Models\PajakKendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 8888 XX', 'tahun_pajak' => 2025],
            [
                'tanggal_jatuh_tempo' => '2025-12-25',
                'jumlah_pajak' => 5200000,
                'status_pembayaran' => 'Belum Bayar',
                'tanggal_bayar' => null,
                'denda' => 0,
            ]
        );

        // 4. Paid Motor (Lunas)
        \App\Models\Kendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 2020 RR'],
            [
                'nomor_rangka' => 'MHF6677889900999',
                'nomor_mesin' => 'E9988776',
                'merk' => 'Yamaha',
                'tipe_model' => 'NMAX 155',
                'tahun_pembuatan' => 2022,
                'warna' => 'Merah Matte',
                'jenis_kendaraan' => 'Motor',
                'nama_pemilik' => 'Joko Susilo',
                'alamat_pemilik' => 'Kotagede, Yogyakarta',
            ]
        );

        \App\Models\PajakKendaraan::updateOrCreate(
            ['nomor_polisi' => 'AB 2020 RR', 'tahun_pajak' => 2025],
            [
                'tanggal_jatuh_tempo' => '2025-03-10',
                'jumlah_pajak' => 450000,
                'status_pembayaran' => 'Lunas',
                'tanggal_bayar' => '2025-03-05',
                'denda' => 0,
            ]
        );

        // Additional 10 Vehicles
        $additionalVehicles = [
            ['AB 1111 AA', 'Toyota', 'Raize', 2022, 'Biru', 'Mobil', 'Ahmad Dani', 'Sleman'],
            ['AB 2222 BB', 'Honda', 'HRV', 2023, 'Merah', 'Mobil', 'Budi Gunawan', 'Bantul'],
            ['AB 3333 CC', 'Suzuki', 'XL7', 2021, 'Abu-abu', 'Mobil', 'Candra Wijaya', 'Kota Yogyakarta'],
            ['AB 4444 DD', 'Daihatsu', 'Rocky', 2022, 'Kuning', 'Mobil', 'Dedi Kurniawan', 'Gunungkidul'],
            ['AB 5555 EE', 'Mazda', 'CX-5', 2020, 'Soul Red', 'Mobil', 'Eko Prasetyo', 'Kulon Progo'],
            ['AB 6666 FF', 'Honda', 'Vario 160', 2023, 'Hitam', 'Motor', 'Fajar Sidik', 'Sleman'],
            ['AB 7777 GG', 'Yamaha', 'XMAX', 2021, 'Biru Matte', 'Motor', 'Guntur Pratama', 'Bantul'],
            ['AB 9999 HH', 'Wuling', 'Air EV', 2024, 'Cyan', 'Mobil', 'Hendra Hartono', 'Kota Yogyakarta'],
            ['AB 1212 II', 'Hyundai', 'Ioniq 5', 2023, 'Gold', 'Mobil', 'Indra Setiawan', 'Sleman'],
            ['AB 3434 JJ', 'Kia', 'Sonet', 2022, 'Silver', 'Mobil', 'Jajang Mulyana', 'Bantul'],
        ];

        foreach ($additionalVehicles as $index => $v) {
            \App\Models\Kendaraan::updateOrCreate(
                ['nomor_polisi' => $v[0]],
                [
                    'nomor_rangka' => 'MHF' . rand(100000000, 999999999) . $index,
                    'nomor_mesin' => 'E' . rand(1000000, 9999999),
                    'merk' => $v[1],
                    'tipe_model' => $v[2],
                    'tahun_pembuatan' => $v[3],
                    'warna' => $v[4],
                    'jenis_kendaraan' => $v[5],
                    'nama_pemilik' => $v[6],
                    'alamat_pemilik' => 'Jl. Kebahagiaan No. ' . ($index + 1) . ', ' . $v[7],
                ]
            );

            \App\Models\PajakKendaraan::updateOrCreate(
                ['nomor_polisi' => $v[0], 'tahun_pajak' => 2025],
                [
                    'tanggal_jatuh_tempo' => date('Y-m-d', strtotime('2025-' . rand(1, 12) . '-' . rand(1, 28))),
                    'jumlah_pajak' => $v[5] == 'Mobil' ? rand(2000000, 6000000) : rand(300000, 600000),
                    'status_pembayaran' => rand(0, 1) ? 'Lunas' : 'Belum Bayar',
                    'tanggal_bayar' => null,
                    'denda' => rand(0, 1) ? rand(50000, 200000) : 0,
                ]
            );
        }
    }
}
