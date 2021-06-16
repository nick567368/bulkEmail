<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BulkSms
 * @package App\Models
 * @version June 4, 2021, 4:57 pm UTC
 *
 * @property string $tilte
 * @property jsonb $email
 * @property string $screem
 * @property string $screen
 * @property string $message
 * @property string $image_path
 * @property string $image_name
 */
class BulkSms extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'bulk_sms';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'email',
        'users',
        'screen',
        'message',
        'image_path',
        'image_name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tilte' => 'string',
        'screen' => 'string',
        'users'=> 'array',
        'image_path' => 'string',
        'image_name' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    // public function getUsersAttribute()
    // {
    //     return json_decode($this->attributes['users']);
    // }
    // public function setUsersAttribute(array $val)
    // {
    //     $this->attributes['users'] = json_encode([]);

    // }
}