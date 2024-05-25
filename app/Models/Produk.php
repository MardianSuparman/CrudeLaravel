<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi', 'harga', 'image', 'id_merek'];
    protected $visible = ['nama', 'deskripsi', 'harga', 'image', 'id_merek'];

    public function Merek(){
        return $this->belongsTo(Merek::class, 'id_merek');
    }
}
