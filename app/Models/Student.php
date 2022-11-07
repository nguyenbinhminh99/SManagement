<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone_number',
        'email',
        'gender',
        'identification',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static $logAttributes = [
        'firstname',
        'lastname',
        'phone_number',
        'email',
        'gender',
        'identification',
        'address'];

    protected static $logName = 'CRUD Students';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }


}
