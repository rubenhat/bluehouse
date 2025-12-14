<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'is_available',
        'image'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Scope untuk menu yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
