<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SlaRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // BAGIAN 1: USER & AKUN
        // Admin
        User::create([ 
            'name' => 'Super Administrator', 'username' => 'admin', 'email' => 'admin@citizenlink.com',
            'password' => Hash::make('admin123'), 'role' => 'admin', 'nik' => null,
        ]);

        // Petugas (Dummy Data)
        $petugasData = [
            ['nama' => 'Budi Petugas', 'username' => 'petugas_budi', 'email' => 'budi@citizenlink.com'],
            ['nama' => 'Siti Petugas', 'username' => 'petugas_siti', 'email' => 'siti@citizenlink.com'],
            ['nama' => 'Joko Petugas', 'username' => 'petugas_joko', 'email' => 'joko@citizenlink.com'],
        ];

        foreach ($petugasData as $p) {
            User::create([
                'nik' => '555' . rand(1000000000000, 9999999999999),
                'name' => $p['nama'], 'username' => $p['username'], 'email' => $p['email'],
                'password' => Hash::make('petugas123'), 'role' => 'petugas',
            ]);
        }

        // Warga Dummy
        User::create([
            'nik' => '1234567890123456', 'name' => 'Wildan', 'username' => 'warga',
            'email' => 'warga@citizenlink.com', 'password' => Hash::make('password'), 'role' => 'masyarakat',
        ]);

        // BAGIAN 2: KAMUS SLA & PRIORITAS (KEYWORD)
        // 1. BENCANA & DARURAT (Prioritas: Sangat Tinggi)
        $darurat = [
            'banjir', 'kebakaran', 'longsor', 'tanah longsor', 'gempa', 'tsunami', 'angin puting beliung', 
            'angin kencang', 'pohon tumbang', 'tumbang', 'banjir bandang', 'tanggul jebol',
            'kecelakaan', 'tabrakan', 'korban jiwa', 'tenggelam', 'hanyut', 'serangan jantung', 
            'pingsan', 'berdarah', 'ambulans', 'butuh medis', 'mayat', 'jenazah',
            'gas bocor', 'bocor gas', 'ledakan', 'meledak', 'ular', 'tawon', 'buaya', 'evakuasi', 'darurat'
        ];
        foreach($darurat as $k) SlaRule::create(['kategori' => 'Bencana & Darurat', 'keyword' => $k, 'prioritas' => 'Sangat Tinggi']);

        // 2. INFRASTRUKTUR KRITIS (Prioritas: Tinggi)
        $infra = [
            'jalan rusak', 'jalan berlubang', 'lubang besar', 'aspal rusak', 'jalan amblas', 'jalan hancur', 
            'jalan gelombang', 'polisi tidur', 'marka jalan', 'trotoar rusak',
            'jembatan rusak', 'jembatan putus', 'jembatan goyang', 'tanggul retak', 'tembok retak', 
            'tiang miring', 'tiang roboh', 'kabel putus', 'kabel menjuntai', 'gorong-gorong', 'drainase',
            'lampu merah mati', 'traffic light mati', 'lampu jalan mati', 'pju mati', 'gelap gulita', 'rambu roboh'
        ];
        foreach($infra as $k) SlaRule::create(['kategori' => 'Infrastruktur Kritis', 'keyword' => $k, 'prioritas' => 'Tinggi']);

        // 3. UTILITAS UMUM (Prioritas: Tinggi)
        $utilitas = [
            'air mati', 'pdam mati', 'air kotor', 'air keruh', 'air mampet', 'pipa bocor', 'pipa pecah', 'pompa rusak',
            'listrik padam', 'mati lampu', 'biarpet', 'tegangan naik turun', 'trafo meledak', 'token listrik',
            'internet mati', 'wifi mati', 'sinyal hilang', 'kabel optik', 'telepon mati'
        ];
        foreach($utilitas as $k) SlaRule::create(['kategori' => 'Utilitas Umum', 'keyword' => $k, 'prioritas' => 'Tinggi']);

        // 4. KESEHATAN & LINGKUNGAN (Prioritas: Sedang)
        $lingkungan = [
            'sampah', 'tumpukan sampah', 'buang sampah', 'bakar sampah', 'asap', 'bau busuk', 'bau menyengat',
            'sungai kotor', 'sungai meluap', 'kali kotor', 'selokan mampet', 'got mampet', 'limbah', 'limbah pabrik',
            'jentik nyamuk', 'demam berdarah', 'dbd', 'fogging', 'tikus', 'kecoak', 'kucing liar', 'anjing liar',
            'pohon rindang', 'potong pohon', 'rumput liar', 'ilalang', 'polusi'
        ];
        foreach($lingkungan as $k) SlaRule::create(['kategori' => 'Kesehatan & Lingkungan', 'keyword' => $k, 'prioritas' => 'Sedang']);

        // 5. KETERTIBAN & KEAMANAN (Prioritas: Sedang)
        $ketertiban = [
            'maling', 'pencurian', 'begal', 'jambret', 'copet', 'perampokan', 'pembobolan', 'orang mencurigakan',
            'tawuran', 'berantem', 'keributan', 'mabuk', 'pesta miras', 'judi', 'narkoba', 'transaksi narkoba',
            'berisik', 'musik keras', 'knalpot brong', 'balap liar', 'trek trekan',
            'parkir liar', 'parkir sembarangan', 'menghalangi jalan', 'pedagang kaki lima', 'pkl', 'bangunan liar',
            'vandalisme', 'coret coret', 'preman', 'pemalakan', 'pungli', 'orang gila', 'odgj', 'gelandangan', 'pengemis'
        ];
        foreach($ketertiban as $k) SlaRule::create(['kategori' => 'Ketertiban & Keamanan', 'keyword' => $k, 'prioritas' => 'Sedang']);

        // 6. PELAYANAN PUBLIK (Prioritas: Rendah)
        $pelayanan = [
            'ktp', 'kk', 'kartu keluarga', 'akta', 'surat pindah', 'surat kematian', 'pembuatan sim', 'skck',
            'bansos', 'blt', 'pkh', 'sembako', 'bantuan', 'dana desa',
            'antrean panjang', 'pelayanan lambat', 'petugas kasar', 'petugas tidak ramah', 'kantor tutup', 
            'calo', 'biaya mahal', 'pungutan liar'
        ];
        foreach($pelayanan as $k) SlaRule::create(['kategori' => 'Pelayanan Publik', 'keyword' => $k, 'prioritas' => 'Rendah']);
    }
}