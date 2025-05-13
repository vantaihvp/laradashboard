<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Navigation extends Model
{
    
    protected $fillable = [
        'menu_name',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'navigation_id')->where('status', 1)->orderBy('menu_order');
    }


}
