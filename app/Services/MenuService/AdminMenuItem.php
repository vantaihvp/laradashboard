<?php

namespace App\Services\MenuService;

class AdminMenuItem
{
    protected string $label;
    protected ?string $icon = null;
    protected ?string $route = null;
    protected bool $active = false;
    protected ?string $id = null;
    /** @var AdminMenuItem[] */
    protected array $children = [];
    protected ?string $filter = null;
    protected ?string $target = null;
    protected int $priority = 1;
    protected array $permissions = [];
    protected bool $allowed = true;

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function setRoute(?string $route): self
    {
        $this->route = $route;
        return $this;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param AdminMenuItem[] $children
     */
    public function setChildren(array $children): self
    {
        $this->children = $children;
        return $this;
    }

    public function setFilter(?string $filter): self
    {
        $this->filter = $filter;
        return $this;
    }

    public function setTarget(?string $target): self
    {
        $this->target = $target;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string|array $permissions
     */
    public function setPermission(string|array $permissions): bool
    {
        $this->permissions = (array)$permissions;
        $user = auth()->user();
        // If no permissions set, allow by default
        if (empty($this->permissions)) {
            return true;
        }
        foreach ($this->permissions as $permission) {
            if ($user && $user->can($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string|array $permissions
     */
    public function isPermission(string|array $permissions): self|false
    {
        $permissions = (array)$permissions;
        $user = auth()->user();
        if (empty($permissions)) {
            return $this;
        }
        foreach ($permissions as $permission) {
            if ($user && $user->can($permission)) {
                return $this;
            }
        }
        return false;
    }

    public function toArray(): array
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
            'priority' => $this->priority,
        ];
    }
}
