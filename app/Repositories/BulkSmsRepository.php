<?php

namespace App\Repositories;

use App\Models\BulkSms;
use App\Repositories\BaseRepository;

/**
 * Class BulkSmsRepository
 * @package App\Repositories
 * @version June 4, 2021, 4:57 pm UTC
*/

class BulkSmsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tilte',
        'email',
        'screem',
        'screen',
        'message',
        'image_path',
        'image_name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BulkSms::class;
    }
}
