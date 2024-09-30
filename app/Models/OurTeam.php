<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'our_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'specialized_id',
        'full_name',
        'position',
        'experience',
        'description',
        'image',
        'alt_text',
        'languages',
        'status',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'languages' => 'json',
    ];

    public function languages(){
        return $this->belongsToMany(TeamLanguage::class);
    }
}
