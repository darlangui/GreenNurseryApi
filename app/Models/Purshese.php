<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purshese extends Model
{
    use HasFactory;

    protected $fillable = ['client_email', 'plant_name', 'freight_state', 'status', 'mount', 'value'];
}
