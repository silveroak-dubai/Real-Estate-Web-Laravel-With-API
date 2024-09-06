<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module_id','name','slug'];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function module(){
        return $this->belongsTo(Module::class,'module_id','id');
    }
}
