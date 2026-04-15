<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = ['invoice_id', 'type', 'sent_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
