<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationItem extends Model
{
    protected $fillable = [
        'navigation_id',
        'menu_label',
        'link',
        'page_id',
        'parent_id',
        'css_class',
        'css_id',
        'menu_order',
        'status',
    ];

    public function navigation(): BelongsTo
    {
        return $this->belongsTo(Navigation::class, 'navigation_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->where('status', 1)->orderBy('menu_order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }
}
