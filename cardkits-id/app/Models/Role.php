<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'is_active',
        'sort_order',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Role types
     */
    const TYPES = [
        'user' => 'User',
        'admin' => 'Administrator',
        'super_admin' => 'Super Administrator',
        'moderator' => 'Moderator',
        'support' => 'Support',
        'analyst' => 'Analyst'
    ];

    /**
     * Default permissions for each role type
     */
    const DEFAULT_PERMISSIONS = [
        'user' => [
            'cards.view_own',
            'cards.create',
            'cards.edit_own',
            'cards.delete_own',
            'components.view_own',
            'components.create',
            'components.edit_own',
            'components.delete_own',
            'analytics.view_own',
            'appointments.view_own',
            'appointments.create',
            'appointments.edit_own',
            'appointments.delete_own',
            'forms.view_own',
            'forms.create',
            'forms.edit_own',
            'forms.delete_own'
        ],
        'admin' => [
            'cards.view_all',
            'cards.create',
            'cards.edit_all',
            'cards.delete_all',
            'components.view_all',
            'components.create',
            'components.edit_all',
            'components.delete_all',
            'analytics.view_all',
            'appointments.view_all',
            'appointments.create',
            'appointments.edit_all',
            'appointments.delete_all',
            'forms.view_all',
            'forms.create',
            'forms.edit_all',
            'forms.delete_all',
            'users.view',
            'users.edit',
            'subscriptions.view',
            'subscriptions.edit',
            'templates.view',
            'templates.create',
            'templates.edit',
            'templates.delete'
        ],
        'super_admin' => [
            'cards.view_all',
            'cards.create',
            'cards.edit_all',
            'cards.delete_all',
            'components.view_all',
            'components.create',
            'components.edit_all',
            'components.delete_all',
            'analytics.view_all',
            'appointments.view_all',
            'appointments.create',
            'appointments.edit_all',
            'appointments.delete_all',
            'forms.view_all',
            'forms.create',
            'forms.edit_all',
            'forms.delete_all',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.edit',
            'subscriptions.delete',
            'templates.view',
            'templates.create',
            'templates.edit',
            'templates.delete',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',
            'system.settings',
            'system.backup',
            'system.logs'
        ]
    ];

    /**
     * Get the users with this role
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot(['assigned_at', 'expires_at', 'assigned_by', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the permissions for this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withPivot(['is_granted', 'constraints'])
            ->withTimestamps();
    }

    /**
     * Scope for active roles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for roles by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for user roles
     */
    public function scopeUserRoles($query)
    {
        return $query->where('type', 'user');
    }

    /**
     * Scope for admin roles
     */
    public function scopeAdminRoles($query)
    {
        return $query->whereIn('type', ['admin', 'super_admin']);
    }

    /**
     * Scope for roles ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get type label attribute
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Check if role is for users
     */
    public function isUserRole()
    {
        return $this->type === 'user';
    }

    /**
     * Check if role is for admins
     */
    public function isAdminRole()
    {
        return in_array($this->type, ['admin', 'super_admin']);
    }

    /**
     * Check if role is super admin
     */
    public function isSuperAdmin()
    {
        return $this->type === 'super_admin';
    }

    /**
     * Check if role is active
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Get default permissions for this role type
     */
    public function getDefaultPermissions()
    {
        return self::DEFAULT_PERMISSIONS[$this->type] ?? [];
    }

    /**
     * Check if role has specific permission
     */
    public function hasPermission($permission)
    {
        // Check explicit permissions
        $explicitPermission = $this->permissions()
            ->where('slug', $permission)
            ->wherePivot('is_granted', true)
            ->first();

        if ($explicitPermission) {
            return true;
        }

        // Check default permissions
        $defaultPermissions = $this->getDefaultPermissions();
        return in_array($permission, $defaultPermissions);
    }

    /**
     * Check if role has any of the specified permissions
     */
    public function hasAnyPermission($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if role has all of the specified permissions
     */
    public function hasAllPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Grant permission to role
     */
    public function grantPermission($permission, $constraints = null)
    {
        $permissionModel = Permission::where('slug', $permission)->first();
        
        if (!$permissionModel) {
            return false;
        }

        $this->permissions()->syncWithoutDetaching([
            $permissionModel->id => [
                'is_granted' => true,
                'constraints' => $constraints
            ]
        ]);

        return true;
    }

    /**
     * Revoke permission from role
     */
    public function revokePermission($permission)
    {
        $permissionModel = Permission::where('slug', $permission)->first();
        
        if (!$permissionModel) {
            return false;
        }

        $this->permissions()->detach($permissionModel->id);
        return true;
    }

    /**
     * Deny permission to role
     */
    public function denyPermission($permission, $constraints = null)
    {
        $permissionModel = Permission::where('slug', $permission)->first();
        
        if (!$permissionModel) {
            return false;
        }

        $this->permissions()->syncWithoutDetaching([
            $permissionModel->id => [
                'is_granted' => false,
                'constraints' => $constraints
            ]
        ]);

        return true;
    }

    /**
     * Get all permissions for this role (including defaults)
     */
    public function getAllPermissions()
    {
        $explicitPermissions = $this->permissions()
            ->wherePivot('is_granted', true)
            ->pluck('slug')
            ->toArray();

        $defaultPermissions = $this->getDefaultPermissions();
        
        return array_unique(array_merge($explicitPermissions, $defaultPermissions));
    }

    /**
     * Get denied permissions for this role
     */
    public function getDeniedPermissions()
    {
        return $this->permissions()
            ->wherePivot('is_granted', false)
            ->pluck('slug')
            ->toArray();
    }

    /**
     * Get permission constraints
     */
    public function getPermissionConstraints($permission)
    {
        $permissionModel = Permission::where('slug', $permission)->first();
        
        if (!$permissionModel) {
            return null;
        }

        $rolePermission = $this->permissions()
            ->where('permission_id', $permissionModel->id)
            ->first();

        return $rolePermission ? $rolePermission->pivot->constraints : null;
    }

    /**
     * Check if role can perform action on resource
     */
    public function can($action, $resource = null, $context = [])
    {
        $permission = $this->buildPermissionString($action, $resource);
        
        if (!$this->hasPermission($permission)) {
            return false;
        }

        // Check constraints if any
        $constraints = $this->getPermissionConstraints($permission);
        if ($constraints) {
            return $this->evaluateConstraints($constraints, $context);
        }

        return true;
    }

    /**
     * Build permission string from action and resource
     */
    protected function buildPermissionString($action, $resource)
    {
        if ($resource) {
            return $resource . '.' . $action;
        }
        
        return $action;
    }

    /**
     * Evaluate permission constraints
     */
    protected function evaluateConstraints($constraints, $context)
    {
        foreach ($constraints as $constraint) {
            if (!$this->evaluateConstraint($constraint, $context)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Evaluate a single constraint
     */
    protected function evaluateConstraint($constraint, $context)
    {
        $field = $constraint['field'] ?? '';
        $operator = $constraint['operator'] ?? 'equals';
        $value = $constraint['value'] ?? '';

        if (!isset($context[$field])) {
            return true; // Field not present, assume allowed
        }

        $contextValue = $context[$field];

        switch ($operator) {
            case 'equals':
                return $contextValue == $value;
            case 'not_equals':
                return $contextValue != $value;
            case 'contains':
                return str_contains($contextValue, $value);
            case 'greater_than':
                return $contextValue > $value;
            case 'less_than':
                return $contextValue < $value;
            case 'in':
                return in_array($contextValue, (array) $value);
            case 'not_in':
                return !in_array($contextValue, (array) $value);
            case 'regex':
                return preg_match($value, $contextValue);
            default:
                return true;
        }
    }

    /**
     * Assign role to user
     */
    public function assignToUser($user, $assignedBy = null, $notes = null, $expiresAt = null)
    {
        $this->users()->attach($user->id, [
            'assigned_at' => now(),
            'assigned_by' => $assignedBy,
            'notes' => $notes,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Remove role from user
     */
    public function removeFromUser($user)
    {
        $this->users()->detach($user->id);
    }

    /**
     * Get users count with this role
     */
    public function getUsersCount()
    {
        return $this->users()->count();
    }

    /**
     * Get active users count with this role
     */
    public function getActiveUsersCount()
    {
        return $this->users()->where('is_active', true)->count();
    }

    /**
     * Check if role is assignable
     */
    public function isAssignable()
    {
        return $this->is_active && $this->type !== 'super_admin';
    }

    /**
     * Get role usage statistics
     */
    public function getUsageStats()
    {
        return [
            'total_users' => $this->getUsersCount(),
            'active_users' => $this->getActiveUsersCount(),
            'permissions_count' => count($this->getAllPermissions()),
            'denied_permissions_count' => count($this->getDeniedPermissions())
        ];
    }

    /**
     * Clone role with new name
     */
    public function clone($newName, $newSlug = null)
    {
        $newSlug = $newSlug ?: \Str::slug($newName);
        
        $clonedRole = $this->replicate();
        $clonedRole->name = $newName;
        $clonedRole->slug = $newSlug;
        $clonedRole->description = 'Cloned from ' . $this->name;
        $clonedRole->save();

        // Clone permissions
        foreach ($this->permissions as $permission) {
            $clonedRole->permissions()->attach($permission->id, [
                'is_granted' => $permission->pivot->is_granted,
                'constraints' => $permission->pivot->constraints
            ]);
        }

        return $clonedRole;
    }

    /**
     * Get role hierarchy level
     */
    public function getHierarchyLevel()
    {
        $hierarchy = [
            'user' => 1,
            'moderator' => 2,
            'support' => 3,
            'analyst' => 4,
            'admin' => 5,
            'super_admin' => 6
        ];

        return $hierarchy[$this->type] ?? 0;
    }

    /**
     * Check if this role can manage another role
     */
    public function canManageRole($otherRole)
    {
        return $this->getHierarchyLevel() > $otherRole->getHierarchyLevel();
    }
}
