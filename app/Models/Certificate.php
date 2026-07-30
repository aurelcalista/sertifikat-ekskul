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
    'sekolah',
    'kelas',
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
}
