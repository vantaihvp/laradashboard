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
    protected ?string $customHtml = null;
    protected bool $isCustomHtml = false;

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
        $this->permissions = is_array($permissions) ? $permissions: [$permissions];
        return $this;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * Configure this menu item to be rendered with custom HTML
     * 
     * @param string $html The custom HTML to render
     * @return self
     */
    public function withHtml(string $html): self
    {
        $this->isCustomHtml = true;
        $this->customHtml = $html;
        return $this;
    }

    /**
     * Check if this menu item uses custom HTML
     * 
     * @return bool
     */
    public function hasCustomHtml(): bool
    {
        return $this->isCustomHtml;
    }

    /**
     * Get the custom HTML for this menu item
     * 
     * @return string|null
     */
    public function getCustomHtml(): ?string
    {
        return $this->customHtml;
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
            'isCustomHtml' => $this->isCustomHtml,
            'customHtml' => $this->customHtml,
        ];
    }
}
