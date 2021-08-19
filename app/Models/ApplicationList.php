<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationList extends Model
{
    use HasFactory;
    protected $table = 'application_list';
    protected $primaryKey = 'ID';
}
