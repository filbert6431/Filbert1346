<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multipleupload extends Model
{
    protected $table      = 'multiuploads';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'filename',
        'ref_table',
        'ref_id',
    ];
}
