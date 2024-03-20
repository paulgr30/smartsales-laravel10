<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'identity_document_id', 'number_id',
        'address', 'phone'
    ];


    // Relaciones
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function identityDocument()
    {
        return $this->belongsTo(IdentityDocument::class);
    }
}
