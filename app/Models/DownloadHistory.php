<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['certificate_id', 'ip_address', 'user_agent'])]
class DownloadHistory extends Model
{
    use HasFactory;

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}
