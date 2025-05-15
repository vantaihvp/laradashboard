<?php

namespace App\Services;

class AdminMenuItem
{
    protected $label;
    protected $icon;
    protected $route;
    protected $active = false;
    protected $id;
    protected $children = [];
    protected $filter;
    protected $target;
    protected $is_logout = false;

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    public function setIsLogout($is_logout)
    {
        $this->is_logout = $is_logout;
        return $this;
    }

    public function toArray()
    {
        return [
            'label' => $this->label,
            'icon' => $this->icon,
            'route' => $this->route,
            'active' => $this->active,
            'id' => $this->id,
            'children' => array_map(function ($child) {
                return $child instanceof self ? $child->toArray() : $child;
            }, $this->children),
            'filter' => $this->filter,
            'target' => $this->target,
            'is_logout' => $this->is_logout,
        ];
    }
}
