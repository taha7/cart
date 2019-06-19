<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasChildren;
use App\Models\Traits\IsOrdered;

class Category extends Model
{
    use HasChildren, IsOrdered;

    protected $fillable = ['name', 'order', 'slug'];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
