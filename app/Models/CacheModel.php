<?php
namespace App\Models;
use CodeIgniter\Model;

class CacheModel extends Model
{
    
    // Table data
    protected $DBGroup = 'default';

    protected $table = 'cache_offers';
    protected $primaryKey = 'offer_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Columns
    protected $allowedFields = [
        'hotel_id',
        'hotel_name',
        'price',
        'source',
        'country_id',
        'country',
        'city_id',
        'city',
        'zip',
        'address',
        'latitude',
        'longitude',
        'star',
        'image'
    ];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
    protected $cleanValidationRules = false;
}