<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Les attributs pouvant être remplis via un formulaire ou une requête API.
     */
    protected $fillable = [
        'user_id',
        'adresse',
        'telephone',
        'permis',
    ];

    /**
     * Relation avec le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
