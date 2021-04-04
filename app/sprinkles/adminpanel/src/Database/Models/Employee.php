<?php

namespace UserFrosting\Sprinkle\AdminPanel\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Employee extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'employees';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'company'
    ];

    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = true;
}
