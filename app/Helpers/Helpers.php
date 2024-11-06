<?php


use Carbon\Carbon;

class Helpers
{
    // Array untuk menyimpan nama hari dalam Bahasa Indonesia
    private static $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];

    // Array untuk menyimpan nama bulan dalam Bahasa Indonesia
    private static $bulan = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember',
    ];

    public static function formatTanggal($tanggal)
    {
        // Membuat objek DateTime dari tanggal
        $date = new \DateTime($tanggal);

        // Mengambil nama hari dan bulan dalam Bahasa Inggris
        $hariInggris = $date->format('l');
        $bulanInggris = $date->format('F');
        $tanggalHari = $date->format('d Y');

        // Mengganti nama hari dan bulan ke Bahasa Indonesia
        $hariIndonesia = self::$hari[$hariInggris];
        $bulanIndonesia = self::$bulan[$bulanInggris];

        // Mengembalikan format tanggal dalam Bahasa Indonesia
        return "{$hariIndonesia}, {$tanggalHari} {$bulanIndonesia}";
    }
}
