<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    //
    use Notifiable;
    protected $table='slots';
    protected $fillable = [
        'room_name',
        'day',
        'check_in_time',
        'check_out_time',
        'status',
        'number_visitors',
        'note',
        'room_support_number'
        
    ];
}
