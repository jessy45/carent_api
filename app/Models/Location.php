<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * Table associée au modèle.
     */
    protected $table = 'locations';

    /**
     * Attributs pouvant être remplis via un formulaire ou une requête API.
     */
    protected $fillable = [
        'client_id',
        'vehicule_id',
        'date_debut',
        'date_fin',
        'montant_total',
    ];

    /**
     * Relation avec le modèle Client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Relation avec le modèle Vehicule.
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }
}

