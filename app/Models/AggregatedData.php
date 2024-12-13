<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AggregatedData extends Model
{
    protected $table = 'aggregated_data';

    protected $fillable = [
        'interval_type',
        'interval_start',
        'total_energy_cost',
    ];
}
