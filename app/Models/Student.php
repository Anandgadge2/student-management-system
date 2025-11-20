<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'profile_photo',
        'age',
        'dob',
        'email',
        'pincode',
        'phone',
        'department_id',
        'country_id',
        'state_id',
        'city_id'
    ];

    protected static function booted()
    {
        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $student->student_id = 'STU' . time() . Str::upper(Str::random(4));
            }
        });
    }

    public function department()
    {   //dump("department relation called"); // code continues
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
