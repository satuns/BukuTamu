<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Guest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nama', 'unit', 'description', 'description_id', 'phone', 'nip'];
    protected $with = ['categoryDescription'];


    public function categoryDescription()
    {
        return $this->belongsTo(CategoryDescription::class, 'description_id')->withDefault();
    }
}
