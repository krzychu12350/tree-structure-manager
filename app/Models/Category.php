<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $fillable = ['name', 'parent_id'];

    public $timestamps = false;

    protected $guarded = ['id'];

    /**
     * Get the index name for the model.
     *
     * @return HasMany
     */
    public function childs()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }
}
