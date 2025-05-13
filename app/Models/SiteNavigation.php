<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteNavigation extends Model
{
    
    protected $fillable = [
        'menu_label',
        'menu_type',
        'link',
        'page_id',
        'css_class',
        'css_id',
        'menu_order',
        'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SiteNavigationItem::class, 'navigation_id')->where('status', 1)->orderBy('menu_order');   
    }


}
