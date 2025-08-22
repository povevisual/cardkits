<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'module',
        'description',
        'action',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Permission modules
     */
    const MODULES = [
        'cards' => 'Digital Cards',
        'components' => 'Card Components',
        'templates' => 'Card Templates',
        'analytics' => 'Analytics',
        'appointments' => 'Appointments',
        'forms' => 'Contact Forms',
        'users' => 'User Management',
        'roles' => 'Role Management',
        'permissions' => 'Permission Management',
        'subscriptions' => 'Subscriptions',
        'billing' => 'Billing',
        'system' => 'System',
        'reports' => 'Reports',
        'settings' => 'Settings'
    ];

    /**
     * Permission actions
     */
    const ACTIONS = [
        'view' => 'View',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'manage' => 'Manage',
        'approve' => 'Approve',
        'reject' => 'Reject',
        'export' => 'Export',
        'import' => 'Import',
        'backup' => 'Backup',
        'restore' => 'Restore',
        'configure' => 'Configure',
        'monitor' => 'Monitor',
        'analyze' => 'Analyze'
    ];

    /**
     * Common permissions
     */
    const COMMON_PERMISSIONS = [
        // Cards
        'cards.view_own' => [
            'name' => 'View Own Cards',
            'module' => 'cards',
            'action' => 'view',
            'description' => 'View digital cards created by the user'
        ],
        'cards.view_all' => [
            'name' => 'View All Cards',
            'module' => 'cards',
            'action' => 'view',
            'description' => 'View all digital cards in the system'
        ],
        'cards.create' => [
            'name' => 'Create Cards',
            'module' => 'cards',
            'action' => 'create',
            'description' => 'Create new digital cards'
        ],
        'cards.edit_own' => [
            'name' => 'Edit Own Cards',
            'module' => 'cards',
            'action' => 'edit',
            'description' => 'Edit digital cards created by the user'
        ],
        'cards.edit_all' => [
            'name' => 'Edit All Cards',
            'module' => 'cards',
            'action' => 'edit',
            'description' => 'Edit any digital card in the system'
        ],
        'cards.delete_own' => [
            'name' => 'Delete Own Cards',
            'module' => 'cards',
            'action' => 'delete',
            'description' => 'Delete digital cards created by the user'
        ],
        'cards.delete_all' => [
            'name' => 'Delete All Cards',
            'module' => 'cards',
            'action' => 'delete',
            'description' => 'Delete any digital card in the system'
        ],

        // Components
        'components.view_own' => [
            'name' => 'View Own Components',
            'module' => 'components',
            'action' => 'view',
            'description' => 'View components of own cards'
        ],
        'components.view_all' => [
            'name' => 'View All Components',
            'module' => 'components',
            'action' => 'view',
            'description' => 'View all components in the system'
        ],
        'components.create' => [
            'name' => 'Create Components',
            'module' => 'components',
            'action' => 'create',
            'description' => 'Create new card components'
        ],
        'components.edit_own' => [
            'name' => 'Edit Own Components',
            'module' => 'components',
            'action' => 'edit',
            'description' => 'Edit components of own cards'
        ],
        'components.edit_all' => [
            'name' => 'Edit All Components',
            'module' => 'components',
            'action' => 'edit',
            'description' => 'Edit any component in the system'
        ],
        'components.delete_own' => [
            'name' => 'Delete Own Components',
            'module' => 'components',
            'action' => 'delete',
            'description' => 'Delete components of own cards'
        ],
        'components.delete_all' => [
            'name' => 'Delete All Components',
            'module' => 'components',
            'action' => 'delete',
            'description' => 'Delete any component in the system'
        ],

        // Templates
        'templates.view' => [
            'name' => 'View Templates',
            'module' => 'templates',
            'action' => 'view',
            'description' => 'View available card templates'
        ],
        'templates.create' => [
            'name' => 'Create Templates',
            'module' => 'templates',
            'action' => 'create',
            'description' => 'Create new card templates'
        ],
        'templates.edit' => [
            'name' => 'Edit Templates',
            'module' => 'templates',
            'action' => 'edit',
            'description' => 'Edit existing card templates'
        ],
        'templates.delete' => [
            'name' => 'Delete Templates',
            'module' => 'templates',
            'action' => 'delete',
            'description' => 'Delete card templates'
        ],

        // Analytics
        'analytics.view_own' => [
            'name' => 'View Own Analytics',
            'module' => 'analytics',
            'action' => 'view',
            'description' => 'View analytics for own cards'
        ],
        'analytics.view_all' => [
            'name' => 'View All Analytics',
            'module' => 'analytics',
            'action' => 'view',
            'description' => 'View all analytics in the system'
        ],
        'analytics.export' => [
            'name' => 'Export Analytics',
            'module' => 'analytics',
            'action' => 'export',
            'description' => 'Export analytics data'
        ],

        // Appointments
        'appointments.view_own' => [
            'name' => 'View Own Appointments',
            'module' => 'appointments',
            'action' => 'view',
            'description' => 'View appointments for own cards'
        ],
        'appointments.view_all' => [
            'name' => 'View All Appointments',
            'module' => 'appointments',
            'action' => 'view',
            'description' => 'View all appointments in the system'
        ],
        'appointments.create' => [
            'name' => 'Create Appointments',
            'module' => 'appointments',
            'action' => 'create',
            'description' => 'Create new appointments'
        ],
        'appointments.edit_own' => [
            'name' => 'Edit Own Appointments',
            'module' => 'appointments',
            'action' => 'edit',
            'description' => 'Edit appointments for own cards'
        ],
        'appointments.edit_all' => [
            'name' => 'Edit All Appointments',
            'module' => 'appointments',
            'action' => 'edit',
            'description' => 'Edit any appointment in the system'
        ],
        'appointments.delete_own' => [
            'name' => 'Delete Own Appointments',
            'module' => 'appointments',
            'action' => 'delete',
            'description' => 'Delete appointments for own cards'
        ],
        'appointments.delete_all' => [
            'name' => 'Delete All Appointments',
            'module' => 'appointments',
            'action' => 'delete',
            'description' => 'Delete any appointment in the system'
        ],

        // Forms
        'forms.view_own' => [
            'name' => 'View Own Forms',
            'module' => 'forms',
            'action' => 'view',
            'description' => 'View contact forms for own cards'
        ],
        'forms.view_all' => [
            'name' => 'View All Forms',
            'module' => 'forms',
            'action' => 'view',
            'description' => 'View all contact forms in the system'
        ],
        'forms.create' => [
            'name' => 'Create Forms',
            'module' => 'forms',
            'action' => 'create',
            'description' => 'Create new contact forms'
        ],
        'forms.edit_own' => [
            'name' => 'Edit Own Forms',
            'module' => 'forms',
            'action' => 'edit',
            'description' => 'Edit contact forms for own cards'
        ],
        'forms.edit_all' => [
            'name' => 'Edit All Forms',
            'module' => 'forms',
            'action' => 'edit',
            'description' => 'Edit any contact form in the system'
        ],
        'forms.delete_own' => [
            'name' => 'Delete Own Forms',
            'module' => 'forms',
            'action' => 'delete',
            'description' => 'Delete contact forms for own cards'
        ],
        'forms.delete_all' => [
            'name' => 'Delete All Forms',
            'module' => 'forms',
            'action' => 'delete',
            'description' => 'Delete any contact form in the system'
        ],

        // Users
        'users.view' => [
            'name' => 'View Users',
            'module' => 'users',
            'action' => 'view',
            'description' => 'View user accounts'
        ],
        'users.create' => [
            'name' => 'Create Users',
            'module' => 'users',
            'action' => 'create',
            'description' => 'Create new user accounts'
        ],
        'users.edit' => [
            'name' => 'Edit Users',
            'module' => 'users',
            'action' => 'edit',
            'description' => 'Edit user accounts'
        ],
        'users.delete' => [
            'name' => 'Delete Users',
            'module' => 'users',
            'action' => 'delete',
            'description' => 'Delete user accounts'
        ],

        // Roles
        'roles.view' => [
            'name' => 'View Roles',
            'module' => 'roles',
            'action' => 'view',
            'description' => 'View user roles'
        ],
        'roles.create' => [
            'name' => 'Create Roles',
            'module' => 'roles',
            'action' => 'create',
            'description' => 'Create new user roles'
        ],
        'roles.edit' => [
            'name' => 'Edit Roles',
            'module' => 'roles',
            'action' => 'edit',
            'description' => 'Edit user roles'
        ],
        'roles.delete' => [
            'name' => 'Delete Roles',
            'module' => 'roles',
            'action' => 'delete',
            'description' => 'Delete user roles'
        ],

        // Permissions
        'permissions.view' => [
            'name' => 'View Permissions',
            'module' => 'permissions',
            'action' => 'view',
            'description' => 'View system permissions'
        ],
        'permissions.create' => [
            'name' => 'Create Permissions',
            'module' => 'permissions',
            'action' => 'create',
            'description' => 'Create new permissions'
        ],
        'permissions.edit' => [
            'name' => 'Edit Permissions',
            'module' => 'permissions',
            'action' => 'edit',
            'description' => 'Edit system permissions'
        ],
        'permissions.delete' => [
            'name' => 'Delete Permissions',
            'module' => 'permissions',
            'action' => 'delete',
            'description' => 'Delete system permissions'
        ],

        // Subscriptions
        'subscriptions.view' => [
            'name' => 'View Subscriptions',
            'module' => 'subscriptions',
            'action' => 'view',
            'description' => 'View user subscriptions'
        ],
        'subscriptions.create' => [
            'name' => 'Create Subscriptions',
            'module' => 'subscriptions',
            'action' => 'create',
            'description' => 'Create new subscriptions'
        ],
        'subscriptions.edit' => [
            'name' => 'Edit Subscriptions',
            'module' => 'subscriptions',
            'action' => 'edit',
            'description' => 'Edit user subscriptions'
        ],
        'subscriptions.delete' => [
            'name' => 'Delete Subscriptions',
            'module' => 'subscriptions',
            'action' => 'delete',
            'description' => 'Delete user subscriptions'
        ],

        // System
        'system.settings' => [
            'name' => 'System Settings',
            'module' => 'system',
            'action' => 'configure',
            'description' => 'Configure system settings'
        ],
        'system.backup' => [
            'name' => 'System Backup',
            'module' => 'system',
            'action' => 'backup',
            'description' => 'Create system backups'
        ],
        'system.logs' => [
            'name' => 'System Logs',
            'module' => 'system',
            'action' => 'view',
            'description' => 'View system logs'
        ]
    ];

    /**
     * Get the roles that have this permission
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withPivot(['is_granted', 'constraints'])
            ->withTimestamps();
    }

    /**
     * Scope for active permissions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for permissions by module
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope for permissions by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for permissions by module and action
     */
    public function scopeByModuleAndAction($query, $module, $action)
    {
        return $query->where('module', $module)->where('action', $action);
    }

    /**
     * Scope for permissions ordered by module and action
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('module')->orderBy('action');
    }

    /**
     * Get module label attribute
     */
    public function getModuleLabelAttribute()
    {
        return self::MODULES[$this->module] ?? ucfirst($this->module);
    }

    /**
     * Get action label attribute
     */
    public function getActionLabelAttribute()
    {
        return self::ACTIONS[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get full permission name
     */
    public function getFullNameAttribute()
    {
        return $this->module_label . ' - ' . $this->action_label;
    }

    /**
     * Check if permission is active
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Check if permission is for specific module
     */
    public function isForModule($module)
    {
        return $this->module === $module;
    }

    /**
     * Check if permission is for specific action
     */
    public function isForAction($action)
    {
        return $this->action === $action;
    }

    /**
     * Check if permission is for viewing
     */
    public function isViewPermission()
    {
        return $this->action === 'view';
    }

    /**
     * Check if permission is for creating
     */
    public function isCreatePermission()
    {
        return $this->action === 'create';
    }

    /**
     * Check if permission is for editing
     */
    public function isEditPermission()
    {
        return $this->action === 'edit';
    }

    /**
     * Check if permission is for deleting
     */
    public function isDeletePermission()
    {
        return $this->action === 'delete';
    }

    /**
     * Check if permission is for managing
     */
    public function isManagePermission()
    {
        return $this->action === 'manage';
    }

    /**
     * Get roles count that have this permission
     */
    public function getRolesCount()
    {
        return $this->roles()->count();
    }

    /**
     * Get active roles count that have this permission
     */
    public function getActiveRolesCount()
    {
        return $this->roles()->where('is_active', true)->count();
    }

    /**
     * Get granted roles count
     */
    public function getGrantedRolesCount()
    {
        return $this->roles()->wherePivot('is_granted', true)->count();
    }

    /**
     * Get denied roles count
     */
    public function getDeniedRolesCount()
    {
        return $this->roles()->wherePivot('is_granted', false)->count();
    }

    /**
     * Check if permission is used by any role
     */
    public function isUsed()
    {
        return $this->getRolesCount() > 0;
    }

    /**
     * Check if permission is granted to any role
     */
    public function isGranted()
    {
        return $this->getGrantedRolesCount() > 0;
    }

    /**
     * Check if permission is denied to any role
     */
    public function isDenied()
    {
        return $this->getDeniedRolesCount() > 0;
    }

    /**
     * Get permission usage statistics
     */
    public function getUsageStats()
    {
        return [
            'total_roles' => $this->getRolesCount(),
            'active_roles' => $this->getActiveRolesCount(),
            'granted_roles' => $this->getGrantedRolesCount(),
            'denied_roles' => $this->getDeniedRolesCount(),
            'is_used' => $this->isUsed(),
            'is_granted' => $this->isGranted(),
            'is_denied' => $this->isDenied()
        ];
    }

    /**
     * Get permission by slug
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Get permissions by module
     */
    public static function getByModule($module)
    {
        return static::where('module', $module)->active()->ordered()->get();
    }

    /**
     * Get permissions by action
     */
    public static function getByAction($action)
    {
        return static::where('action', $action)->active()->ordered()->get();
    }

    /**
     * Get all modules
     */
    public static function getModules()
    {
        return self::MODULES;
    }

    /**
     * Get all actions
     */
    public static function getActions()
    {
        return self::ACTIONS;
    }

    /**
     * Get common permissions
     */
    public static function getCommonPermissions()
    {
        return self::COMMON_PERMISSIONS;
    }

    /**
     * Create permission from common permission data
     */
    public static function createFromCommon($slug, $additionalData = [])
    {
        if (!isset(self::COMMON_PERMISSIONS[$slug])) {
            throw new \InvalidArgumentException("Unknown permission slug: {$slug}");
        }
        
        $data = array_merge(self::COMMON_PERMISSIONS[$slug], $additionalData);
        $data['slug'] = $slug;
        
        return self::create($data);
    }

    /**
     * Create multiple permissions from common permissions
     */
    public static function createFromCommonMultiple($slugs, $additionalData = [])
    {
        $permissions = [];
        
        foreach ($slugs as $slug) {
            $permissions[] = self::createFromCommon($slug, $additionalData);
        }
        
        return $permissions;
    }

    /**
     * Get permission pattern for resource
     */
    public static function getResourcePattern($resource, $action = null)
    {
        if ($action) {
            return $resource . '.' . $action;
        }
        
        return $resource . '.%';
    }

    /**
     * Check if permission slug matches pattern
     */
    public function matchesPattern($pattern)
    {
        if (str_contains($pattern, '%')) {
            $regex = str_replace('%', '.*', $pattern);
            return preg_match('/^' . $regex . '$/', $this->slug);
        }
        
        return $this->slug === $pattern;
    }

    /**
     * Get related permissions (same module or action)
     */
    public function getRelatedPermissions()
    {
        return static::where(function ($query) {
            $query->where('module', $this->module)
                  ->orWhere('action', $this->action);
        })
        ->where('id', '!=', $this->id)
        ->active()
        ->ordered()
        ->get();
    }

    /**
     * Get permission dependencies
     */
    public function getDependencies()
    {
        $dependencies = [];
        
        // View permission is usually required for other actions
        if (!$this->isViewPermission()) {
            $viewPermission = static::where('module', $this->module)
                ->where('action', 'view')
                ->first();
            
            if ($viewPermission) {
                $dependencies[] = $viewPermission;
            }
        }
        
        return $dependencies;
    }

    /**
     * Check if permission has dependencies
     */
    public function hasDependencies()
    {
        return count($this->getDependencies()) > 0;
    }

    /**
     * Get permission impact level
     */
    public function getImpactLevel()
    {
        if ($this->action === 'delete') {
            return 'high';
        }
        
        if ($this->action === 'create' || $this->action === 'edit') {
            return 'medium';
        }
        
        return 'low';
    }

    /**
     * Get permission risk level
     */
    public function getRiskLevel()
    {
        if ($this->module === 'system' || $this->module === 'users') {
            return 'high';
        }
        
        if ($this->module === 'roles' || $this->module === 'permissions') {
            return 'high';
        }
        
        if ($this->action === 'delete') {
            return 'medium';
        }
        
        return 'low';
    }
}
