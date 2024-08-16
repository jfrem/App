<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Get the todos for the category.
     */
    public function todos()
    {
        return $this->hasMany(Todos::class);
    }
}
