<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'code',
    'nomor_sertifikat',
    'nama_siswa',
    'nis',
    'ekskul',
    'jenis_sertifikat',
    'prestasi',
    'tanggal',
    'nama_pembina',
    'jabatan_pembina',
    'template_id',
    'background_path',
    'logo_sekolah',
    'tanda_tangan',
    'status'
])]
class Certificate extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($certificate) {
            if (empty($certificate->code)) {
                $certificate->code = self::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode(): string
    {
        $year = date('Y');
        do {
            $random = strtoupper(Str::random(6)); // 6-character random uppercase alphanumeric
            // Filter non-alphanumeric just in case Str::random includes other things
            $random = preg_replace('/[^A-Z0-9]/', 'X', $random);
            if (strlen($random) < 6) {
                $random = str_pad($random, 6, '9');
            }
            $code = "SK-{$year}-{$random}";
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function downloadHistories(): HasMany
    {
        return $this->hasMany(DownloadHistory::class);
    }

    /**
     * Menghapus background putih/hampir putih dari gambar dan mengembalikannya sebagai Base64 PNG transparan.
     */
    public static function removeWhiteBackground($path)
    {
        if (!$path || !file_exists($path)) {
            return null;
        }

        $info = getimagesize($path);
        if (!$info) {
            return null;
        }

        $mime = $info['mime'];
        if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
            $im = @imagecreatefromjpeg($path);
        } elseif ($mime == 'image/png') {
            $im = @imagecreatefrompng($path);
        } elseif ($mime == 'image/gif') {
            $im = @imagecreatefromgif($path);
        } else {
            return null;
        }

        if (!$im) {
            return null;
        }

        $width = imagesx($im);
        $height = imagesy($im);

        // Buat image baru dengan transparansi penuh
        $new_img = imagecreatetruecolor($width, $height);
        imagealphablending($new_img, false);
        imagesavealpha($new_img, true);

        $transparent = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
        imagefill($new_img, 0, 0, $transparent);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($im, $x, $y);
                $colors = imagecolorsforindex($im, $rgb);

                $r = $colors['red'];
                $g = $colors['green'];
                $b = $colors['blue'];
                $a = $colors['alpha'];

                // Jika pixel berwarna putih atau mendekati putih (threshold RGB > 240)
                if ($r > 240 && $g > 240 && $b > 240) {
                    imagesetpixel($new_img, $x, $y, $transparent);
                } else {
                    $color = imagecolorallocatealpha($new_img, $r, $g, $b, $a);
                    imagesetpixel($new_img, $x, $y, $color);
                }
            }
        }

        ob_start();
        imagepng($new_img);
        $data = ob_get_clean();

        imagedestroy($im);
        imagedestroy($new_img);

        return 'data:image/png;base64,' . base64_encode($data);
    }
}
