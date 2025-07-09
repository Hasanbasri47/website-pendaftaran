<?php
// Aktifkan error untuk debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_pendaftaran");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Fungsi ambil data
function ambil($key) {
    return $_POST[$key] ?? '';
}

// Fungsi simpan file
function simpanFile($field) {
    $dir = "uploads";
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0) return null;
    $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $nama = uniqid($field . "_") . "." . strtolower($ext);
    $path = "$dir/$nama";
    move_uploaded_file($_FILES[$field]['tmp_name'], $path);
    return $path;
}

// Ambil semua data dari formulir
$data = [
    'nama_lengkap' => ambil('nama_lengkap'),
    'nik' => ambil('nik'),
    'nisn' => ambil('nisn'),
    'jenis_kelamin' => ambil('jenis_kelamin'),
    'ttl' => ambil('ttl'),
    'agama' => ambil('agama'),
    'kewarganegaraan' => ambil('kewarganegaraan'),
    'bahasa' => ambil('bahasa'),
    'telepon_siswa' => ambil('telepon_siswa'),
    'jurusan' => ambil('jurusan'),

    'provinsi' => ambil('provinsi'),
    'kabupaten' => ambil('kabupaten'),
    'kecamatan' => ambil('kecamatan'),
    'desa' => ambil('desa'),
    'jalan_siswa' => ambil('jalan_siswa'),
    'kodepos' => ambil('kodepos'),

    'npsn' => ambil('npsn'),
    'nama_sekolah' => ambil('nama_sekolah'),
    'nis_sekolah' => ambil('nis_sekolah'),
    'tahun_lulus' => ambil('tahun_lulus'),
    'nilai_rata2' => ambil('nilai_rata2'),
    'alasan_pindah' => ambil('alasan_pindah'),

    'ekstrakurikuler1' => ambil('ekstrakurikuler1'),
    'alasan1' => ambil('alasan1'),
    'ekstrakurikuler2' => ambil('ekstrakurikuler2'),
    'alasan2' => ambil('alasan2'),

    'nama_ayah' => ambil('nama_ayah'),
    'ttl_ayah' => ambil('ttl_ayah'),
    'pendidikan_ayah' => ambil('pendidikan_ayah'),
    'pekerjaan_ayah' => ambil('pekerjaan_ayah'),
    'alamat_ayah' => ambil('alamat_ayah'),
    'hp_ayah' => ambil('hp_ayah'),
    'penghasilan_ayah' => ambil('penghasilan_ayah'),

    'nama_ibu' => ambil('nama_ibu'),
    'ttl_ibu' => ambil('ttl_ibu'),
    'pendidikan_ibu' => ambil('pendidikan_ibu'),
    'pekerjaan_ibu' => ambil('pekerjaan_ibu'),
    'alamat_ibu' => ambil('alamat_ibu'),
    'hp_ibu' => ambil('hp_ibu'),
    'penghasilan_ibu' => ambil('penghasilan_ibu'),

    'nama_wali' => ambil('nama_wali'),
    'hubungan_wali' => ambil('hubungan_wali'),
    'alamat_wali' => ambil('alamat_wali'),
    'pendidikan_wali' => ambil('pendidikan_wali'),
    'pekerjaan_wali' => ambil('pekerjaan_wali'),
    'penghasilan_wali' => ambil('penghasilan_wali'),
    'hp_wali' => ambil('hp_wali'),

    'gol_darah' => ambil('gol_darah'),
    'riwayat_penyakit' => ambil('riwayat_penyakit'),
    'tinggi_berat' => ambil('tinggi_berat'),
    'catatan_kesehatan' => ambil('catatan_kesehatan'),

    'akta' => simpanFile('akta'),
    'kk' => simpanFile('kk'),
    'ktp' => simpanFile('ktp'),
    'kip' => simpanFile('kip'),
    'kis' => simpanFile('kis'),
    'foto' => simpanFile('foto'),
    'ijazah' => simpanFile('ijazah'),
    'legalisir_ijazah' => simpanFile('legalisir_ijazah'),

    'tanggal_pengisian' => date("Y-m-d H:i:s")
];

// Bangun query insert
$kolom = implode(", ", array_keys($data));
$tandaTanya = implode(", ", array_fill(0, count($data), "?"));
$stmt = $koneksi->prepare("INSERT INTO pendaftaran ($kolom) VALUES ($tandaTanya)");
$stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));

// Jalankan simpan
if ($stmt->execute()) {
    echo "✅ Data berhasil disimpan.";
} else {
    echo "❌ Gagal menyimpan: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>
