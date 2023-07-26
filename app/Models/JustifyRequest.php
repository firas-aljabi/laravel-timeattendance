<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JustifyRequest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'type', 'reason', 'medical_report_file', 'company_id', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
