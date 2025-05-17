<?php

namespace App\Services\MenuService;

class AdminMenuItem
{
    protected string $label;
    protected ?string $icon = null;
    protected ?string $route = null;
    protected bool $active = false;
    protected ?string $id = null;

    protected array $children = [];
    protected ?string $target = null;
    protected int $priority = 1;
    protected array $permissions = [];
    protected bool $allowed = true;
    protected ?string $html = null;

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

    public function setChildren(array $children): self
    {
        $this->children = $children;
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

    public function setPermission(string|array $permissions): self
    {
        $this->permissions = (array)$permissions;
        return $this;
    }

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

    public function userHasPermission(): bool
    {
        if (empty($this->permissions)) {
            return true;
        }
        
        $user = auth()->user();
        foreach ($this->permissions as $permission) {
            if ($user && $user->can($permission)) {
                return true;
            }
        }
        return false;
    }

    public function withHtml(string $html): self
    {
        $this->html = $html;
        return $this;
    }

    /**
     * Configure multiple properties at once.
     *
     * @param array|object $config Key-value pairs for configuration
     * @return self
     */
    public function Html($config): self
    {
        $data = is_object($config) ? (array) $config : $config;
        
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            
            // Special cases for methods that don't follow the setX naming convention
            if ($key === 'html') {
                $this->withHtml($value);
                continue;
            }
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        
        return $this;
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
            'target' => $this->target,
            'priority' => $this->priority,
            'html' => $this->html,
        ];
    }
}
