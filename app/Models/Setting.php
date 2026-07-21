<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'tbl_setting';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'ShowCompanyDetails',
        'web_title',
        'web_meta',
        'web_keyword',
        'web_description',
        'about_us',
        'header_logo',
        'footer_logo',
        'favicon',
        'director_signature',
        'round_seal',
        'contact_1',
        'contact_2',
        'email_1',
        'email_2',
        'Address',
        'corporate_address',
        'play_store_link',
        'app_store_link',
    ];

}
