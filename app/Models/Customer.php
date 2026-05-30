<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'email_2', 'email_3', 'team1_days', 'team2_days'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getEmailRecipientsAttribute()
    {
        return collect([$this->email, $this->email_2, $this->email_3])
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
