<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Finance;
use App\Models\Inventory;
use App\Models\ZisRecord;
use App\Models\Donation;
use App\Models\FridaySchedule;
use App\Models\Qurban;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create permissions
        $permissions = [
            'manage content',
            'manage finance',
            'manage inventory',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create roles and assign permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions($permissions);

        $bendaharaRole = Role::firstOrCreate(['name' => 'Bendahara']);
        $bendaharaRole->syncPermissions(['manage finance', 'manage inventory']);

        $marbotRole = Role::firstOrCreate(['name' => 'Marbot']);
        $marbotRole->syncPermissions(['manage content', 'manage inventory']);

        // 3. Create default users and assign roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@masjid.com'],
            [
                'name' => 'Super Admin DKM',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($superAdminRole);

        $bendahara = User::firstOrCreate(
            ['email' => 'bendahara@masjid.com'],
            [
                'name' => 'Bendahara DKM',
                'password' => Hash::make('bendahara123'),
            ]
        );
        $bendahara->assignRole($bendaharaRole);

        $marbot = User::firstOrCreate(
            ['email' => 'marbot@masjid.com'],
            [
                'name' => 'Marbot / Penulis DKM',
                'password' => Hash::make('marbot123'),
            ]
        );
        $marbot->assignRole($marbotRole);

        // 4. Seed default settings (Masjid Profile)
        Setting::setValue('masjid_name', 'Masjid Raya Al-Hikmah');
        Setting::setValue('masjid_address', 'Jl. Dago No. 123, Coblong, Kota Bandung, Jawa Barat');
        Setting::setValue('masjid_history', 'Masjid Raya Al-Hikmah didirikan pada tahun 1995 di atas tanah wakaf seluas 2.500 meter persegi. Sejak awal pembangunannya, masjid ini telah bertransformasi menjadi pusat peribadatan utama, pembinaan keagamaan, serta motor penggerak kegiatan sosial bagi masyarakat di kawasan Coblong dan sekitarnya.');
        Setting::setValue('masjid_vision', 'Menjadi pusat mercusuar peradaban Islam yang ramah, mandiri, unggul dalam pelayanan, serta transparan menyejahterakan umat.');
        Setting::setValue('masjid_mission', "1. Menyelenggarakan kegiatan ibadah fardhu & sunnah yang tertib dan khusyuk.\n2. Mengembangkan pendidikan Al-Quran, kajian keislaman kontemporer, dan kepemudaan.\n3. Mengelola keuangan donasi jamaah secara akuntabel & transparan menggunakan sistem digital.\n4. Merawat aset fisik dan sarana pendukung ibadah demi kenyamanan dan kekhusyukan jamaah.");
        Setting::setValue('masjid_facilities', "Ruang Shalat Utama Full AC, Perpustakaan Mini Islam, Aula Pertemuan Serbaguna, Area Parkir Ber-Kanopi, Ambulans Layanan Umat Gratis, Air Mineral Galon Dingin/Panas Gratis, Sound System Canggih, Kamar Mandi & Area Wudhu Higienis.");
        Setting::setValue('masjid_legalities', "Keputusan Kementerian Agama RI No. Kemenag-445/2005, Sertifikat Tanah Wakaf BPN No. 1290/WKF/1997, Izin Operasional DKM No. 09/DKM-BDG/1998");
        Setting::setValue('masjid_structure', "Ketua DKM: H. Ahmad Syarifuddin\nSekretaris: Ustadz Rian Hidayat\nBendahara: H. M. Yusuf\nMarbot Utama: Pak Joko");

        // 5. Seed some sample data for visual attractiveness
        // Activities
        Activity::create([
            'title' => 'Kajian Rutin Riyadush Shalihin',
            'description' => 'Kajian mendalam tentang akhlak dan hadits dari kitab Riyadush Shalihin. Terbuka untuk umum, ikhwan dan akhwat.',
            'category' => 'pengajian',
            'event_date' => now()->addDays(2)->toDateString(),
            'event_time' => '18:00 - 19:30 (Ba\'da Maghrib)',
            'speaker' => 'Ustadz Dr. Abdul Somad',
            'location' => 'Ruang Shalat Utama',
        ]);
        Activity::create([
            'title' => 'Tablig Akbar Menyambut Tahun Baru Islam',
            'description' => 'Kajian umum dalam rangka memperingati Tahun Baru Hijriah dengan tema Membuka Lembaran Baru dengan Takwa dan Kesalehan Sosial.',
            'category' => 'tablig_akbar',
            'event_date' => now()->addDays(7)->toDateString(),
            'event_time' => '08:30 - 11:30 WIB',
            'speaker' => 'K.H. Bahauddin Nursalim (Gus Baha)',
            'location' => 'Halaman Utama & Aula Masjid',
        ]);
        Activity::create([
            'title' => 'Program Ramadan: Pesantren Kilat & Tarawih',
            'description' => 'Program pengisian rohani dan ibadah bersama selama bulan suci Ramadan. Menyediakan takjil gratis dan pesantren kilat remaja.',
            'category' => 'ramadan',
            'event_date' => now()->addDays(12)->toDateString(),
            'event_time' => '16:00 - 20:30 WIB',
            'speaker' => 'Ustadz Adi Hidayat, Lc., M.A.',
            'location' => 'Seluruh Area Masjid',
        ]);
        Activity::create([
            'title' => 'Penyaluran Santunan Anak Yatim',
            'description' => 'Penyerahan beasiswa pendidikan dan paket sembako bagi anak yatim dan keluarga dhuafa di wilayah kelurahan Coblong.',
            'category' => 'santunan',
            'event_date' => now()->addDays(4)->toDateString(),
            'event_time' => '09:00 - 12:00 WIB',
            'speaker' => 'Panitia ZIS DKM Al-Hikmah',
            'location' => 'Aula Serbaguna Masjid',
        ]);
        Activity::create([
            'title' => 'Pelatihan Pengurusan Jenazah (Fardhu Kifayah)',
            'description' => 'Pelatihan teoretis dan praktis mengenai tata cara memandikan, mengkafani, menshalatkan, hingga memakamkan jenazah secara syar\'i.',
            'category' => 'pelatihan',
            'event_date' => now()->addDays(15)->toDateString(),
            'event_time' => '08:00 - 15:00 WIB',
            'speaker' => 'Ustadz Drs. H. Muchtar Lutfi',
            'location' => 'Aula Serbaguna Masjid',
        ]);

        // Finances
        Finance::create([
            'type' => 'in',
            'category' => 'infak_jumat',
            'amount' => 5450000,
            'description' => 'Infak Kotak Amal Shalat Jumat Pekan Terakhir',
            'transaction_date' => now()->subDays(4)->toDateString(),
            'user_id' => $bendahara->id,
        ]);
        Finance::create([
            'type' => 'in',
            'category' => 'donasi_digital',
            'amount' => 1250000,
            'description' => 'Donasi digital masuk via QRIS untuk perbaikan tempat wudhu wanita',
            'transaction_date' => now()->subDays(2)->toDateString(),
            'user_id' => $bendahara->id,
        ]);
        Finance::create([
            'type' => 'out',
            'category' => 'operasional',
            'amount' => 450000,
            'description' => 'Pembelian sabun cuci tangan, desinfektan, pembersih lantai, dan tisu toilet masjid',
            'transaction_date' => now()->subDays(3)->toDateString(),
            'user_id' => $bendahara->id,
        ]);
        Finance::create([
            'type' => 'out',
            'category' => 'pemeliharaan',
            'amount' => 1500000,
            'description' => 'Servis berkala dan pembersihan 6 unit AC ruang shalat utama',
            'transaction_date' => now()->subDays(1)->toDateString(),
            'user_id' => $bendahara->id,
        ]);

        // ZIS Records
        ZisRecord::create([
            'type' => 'zakat_fitrah_uang',
            'person_type' => 'muzakki',
            'name' => 'Bapak Budi Hartono',
            'phone' => '08123456789',
            'address' => 'Dago Asri No. 10',
            'amount_money' => 450000,
            'date_recorded' => now()->subDays(5)->toDateString(),
            'notes' => 'Zakat fitrah keluarga (10 jiwa)',
        ]);
        ZisRecord::create([
            'type' => 'zakat_fitrah_beras',
            'person_type' => 'muzakki',
            'name' => 'Ibu Siti Aminah',
            'phone' => '08987654321',
            'address' => 'Jl. Cisitu Indah No. 5',
            'amount_rice' => 10.00, // 4 orang @ 2.5 kg
            'date_recorded' => now()->subDays(4)->toDateString(),
            'notes' => 'Zakat fitrah keluarga (4 jiwa @ 2.5 kg)',
        ]);
        ZisRecord::create([
            'type' => 'zakat_maal',
            'person_type' => 'muzakki',
            'name' => 'H. Hendra Wijaya',
            'phone' => '0811223344',
            'address' => 'Perumahan Dago Elok Kav. 3',
            'amount_money' => 8500000,
            'date_recorded' => now()->subDays(3)->toDateString(),
            'notes' => 'Zakat harta profesi tahunan',
        ]);
        ZisRecord::create([
            'type' => 'zakat_fitrah_uang',
            'person_type' => 'mustahik',
            'name' => 'Mbah Dirjo (Fakir)',
            'phone' => '',
            'address' => 'RT 03 / RW 05 Coblong',
            'amount_money' => 200000,
            'amount_rice' => 5.00,
            'date_recorded' => now()->subDays(1)->toDateString(),
            'notes' => 'Penyaluran zakat fitrah dan beras santunan fakir miskin',
        ]);

        // Inventory
        Inventory::create([
            'item_name' => 'Karpet Sajadah Turkiye',
            'code' => 'INV-KRP-001',
            'quantity' => 12,
            'condition' => 'baik',
            'location' => 'Ruang Shalat Utama',
            'purchase_date' => '2024-03-10',
            'notes' => 'Karpet merah dengan ornamen emas tebal premium',
        ]);
        Inventory::create([
            'item_name' => 'Sound System Mixer Yamaha',
            'code' => 'INV-SND-001',
            'quantity' => 1,
            'condition' => 'baik',
            'location' => 'Ruang Kontrol Audio',
            'purchase_date' => '2025-01-15',
            'notes' => 'Mixer 16 channel untuk mic mimbar, imam, dan adzan',
        ]);
        Inventory::create([
            'item_name' => 'Genset Honda 5kVA',
            'code' => 'INV-GEN-001',
            'quantity' => 1,
            'condition' => 'rusak_ringan',
            'location' => 'Gudang Belakang',
            'purchase_date' => '2023-06-20',
            'notes' => 'Perlu servis busi dan karburator',
        ]);
        Inventory::create([
            'item_name' => 'Air Conditioner Sharp 2 PK',
            'code' => 'INV-AC-001',
            'quantity' => 6,
            'condition' => 'baik',
            'location' => 'Ruang Shalat Utama',
            'purchase_date' => '2024-08-05',
            'notes' => 'Sudah dicuci berkala per Juni 2026',
        ]);

        // Articles
        Article::create([
            'title' => 'Pentingnya Menjaga Keistiqomahan Setelah Ramadan',
            'slug' => 'pentingnya-menjaga-keistiqomahan-setelah-ramadan',
            'content' => "Bulan Ramadan telah meninggalkan kita, namun madrasah spiritual yang kita lalui selama sebulan penuh seyogyanya membekas dalam kehidupan sehari-hari kita. Istiqomah (konsistensi) dalam beribadah adalah tanda diterimanya amal shalih kita di bulan suci tersebut.\n\nDalam sebuah hadits, Rasulullah shallallahu 'alaihi wa sallam bersabda: 'Katakanlah, saya beriman kepada Allah, kemudian istiqomahlah.' (HR. Muslim). Menjaga shalat berjamaah, tilawah Al-Quran walau beberapa halaman, dan senantiasa bersedekah adalah kunci utama agar ruh Ramadan tetap menyala dalam sanubari kita.",
            'category' => 'artikel',
            'image_path' => null,
            'user_id' => $marbot->id,
            'published_at' => now(),
        ]);
        Article::create([
            'title' => 'Khotbah Jumat: Membangun Ukhuwah Islamiyah di Tengah Perbedaan',
            'slug' => 'khotbah-jumat-membangun-ukhuwah-islamiyah',
            'content' => "Ringkasan khotbah Jumat 29 Mei 2026 oleh Ustadz Dr. Abdul Somad.\n\nUmat Islam digambarkan bagaikan satu tubuh. Jika salah satu anggota tubuh sakit, maka seluruh tubuh akan merasakannya. Perbedaan dalam masalah cabang (furu'iyah) dalam agama tidak boleh meretakkan ukhuwah Islamiyah di antara kita. Khotib berpesan agar masjid senantiasa menjadi tempat pemersatu umat, bukan pemecah belah. Kita harus mengedepankan persamaan akidah dan saling toleransi dalam ranah ijtihadiyah.",
            'category' => 'khotbah',
            'image_path' => null,
            'user_id' => $marbot->id,
            'published_at' => now()->subDays(4),
        ]);

        // Donations (Digital Donation simulation records)
        Donation::create([
            'donor_name' => 'Hamba Allah',
            'donor_phone' => '081299998888',
            'amount' => 250000,
            'payment_method' => 'qris',
            'status' => 'success',
            'reference_id' => 'TX-QRIS-992831',
            'notes' => 'Semoga berkah untuk keluarga kami',
        ]);

        // Friday Schedules
        FridaySchedule::create([
            'date' => now()->next(\Carbon\Carbon::FRIDAY)->toDateString(),
            'imam' => 'Ustadz KH. M. Yusuf, Lc.',
            'khotib' => 'Ustadz Adi Hidayat, Lc., M.A.',
            'muadzin' => 'Akhi Rasyid',
            'notes' => 'Tema khotbah: Pentingnya Adab Menuntut Ilmu',
        ]);
        FridaySchedule::create([
            'date' => now()->next(\Carbon\Carbon::FRIDAY)->addWeeks(1)->toDateString(),
            'imam' => 'Ustadz H. Rahmat Hidayat',
            'khotib' => 'Prof. Dr. KH. Didin Hafidhuddin',
            'muadzin' => 'Akhi Fauzan',
            'notes' => 'Tema khotbah: Membangun Ekonomi Umat Mandiri',
        ]);

        // Qurban Registries (1447 H / 2026)
        Qurban::create([
            'year' => '1447 H / 2026',
            'participant_name' => 'Bapak H. Sukarno',
            'phone' => '081234567890',
            'type' => 'sapi',
            'group_number' => 1,
            'amount_paid' => 3500000,
            'status' => 'lunas',
            'notes' => 'Qurban sapi kelompok 1 slot 1',
        ]);
        Qurban::create([
            'year' => '1447 H / 2026',
            'participant_name' => 'Ibu Hj. Aminah',
            'phone' => '081234567891',
            'type' => 'sapi',
            'group_number' => 1,
            'amount_paid' => 3500000,
            'status' => 'lunas',
            'notes' => 'Qurban sapi kelompok 1 slot 2',
        ]);
        Qurban::create([
            'year' => '1447 H / 2026',
            'participant_name' => 'Bapak Joko Santoso',
            'phone' => '081234567892',
            'type' => 'kambing',
            'group_number' => null,
            'amount_paid' => 3000000,
            'status' => 'lunas',
            'notes' => 'Kambing tipe A premium',
        ]);
        Qurban::create([
            'year' => '1447 H / 2026',
            'participant_name' => 'Bapak Ahmad Fauzi',
            'phone' => '081234567893',
            'type' => 'sapi',
            'group_number' => 1,
            'amount_paid' => 1500000,
            'status' => 'belum_lunas',
            'notes' => 'Qurban sapi kelompok 1 slot 3 - DP 1.500.000',
        ]);
    }
}
