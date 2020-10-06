<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'type',
    ];

    public function transactions()
    {
      return $this->hasMany('App\Models\Transaction');
    }
}
