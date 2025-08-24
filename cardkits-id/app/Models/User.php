<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the bio links for the user
     */
    public function bioLinks(): HasMany
    {
        return $this->hasMany(BioLink::class);
    }

    /**
     * Get the digital cards for the user
     */
    public function digitalCards(): HasMany
    {
        return $this->hasMany(DigitalCard::class);
    }

    /**
     * Get the appointments for the user
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the user subscriptions for the user
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get the active subscription for the user
     */
    public function activeSubscription()
    {
        return $this->userSubscriptions()
            ->where('status', 'active')
            ->orWhere('status', 'trialing')
            ->first();
    }

    /**
     * Get the roles for the user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot(['assigned_at', 'expires_at', 'assigned_by', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get the primary role for the user
     */
    public function primaryRole()
    {
        return $this->roles()->orderBy('sort_order')->first();
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }
        
        return $this->roles()->where('id', $role->id)->exists();
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasAnyRole($roles)
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has all of the specified roles
     */
    public function hasAllRoles($roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has any of the specified permissions
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
     * Check if user has all of the specified permissions
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
     * Check if user can perform action on resource
     */
    public function can($action, $resource = null, $context = [])
    {
        foreach ($this->roles as $role) {
            if ($role->can($action, $resource, $context)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is moderator
     */
    public function isModerator()
    {
        return $this->hasRole('moderator');
    }

    /**
     * Check if user is support
     */
    public function isSupport()
    {
        return $this->hasRole('support');
    }

    /**
     * Check if user is analyst
     */
    public function isAnalyst()
    {
        return $this->hasRole('analyst');
    }

    /**
     * Assign role to user
     */
    public function assignRole($role, $assignedBy = null, $notes = null, $expiresAt = null)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->first();
        }
        
        if (!$role) {
            return false;
        }
        
        $this->roles()->attach($role->id, [
            'assigned_at' => now(),
            'assigned_by' => $assignedBy,
            'notes' => $notes,
            'expires_at' => $expiresAt
        ]);
        
        return true;
    }

    /**
     * Remove role from user
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->first();
        }
        
        if (!$role) {
            return false;
        }
        
        $this->roles()->detach($role->id);
        return true;
    }

    /**
     * Sync user roles
     */
    public function syncRoles($roles, $assignedBy = null)
    {
        $roleIds = [];
        
        foreach ($roles as $role) {
            if (is_string($role)) {
                $roleModel = Role::where('slug', $role)->first();
                if ($roleModel) {
                    $roleIds[] = $roleModel->id;
                }
            } else {
                $roleIds[] = $role->id;
            }
        }
        
        $this->roles()->sync($roleIds);
        
        // Update assignment details for new roles
        foreach ($roleIds as $roleId) {
            $this->roles()->updateExistingPivot($roleId, [
                'assigned_at' => now(),
                'assigned_by' => $assignedBy
            ]);
        }
    }

    /**
     * Get user permissions
     */
    public function getPermissions()
    {
        $permissions = [];
        
        foreach ($this->roles as $role) {
            $rolePermissions = $role->getAllPermissions();
            $permissions = array_merge($permissions, $rolePermissions);
        }
        
        return array_unique($permissions);
    }

    /**
     * Get user denied permissions
     */
    public function getDeniedPermissions()
    {
        $deniedPermissions = [];
        
        foreach ($this->roles as $role) {
            $roleDeniedPermissions = $role->getDeniedPermissions();
            $deniedPermissions = array_merge($deniedPermissions, $roleDeniedPermissions);
        }
        
        return array_unique($deniedPermissions);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription()
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Check if user can create more cards
     */
    public function canCreateMoreCards()
    {
        $subscription = $this->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        return $subscription->canCreateMoreCards();
    }

    /**
     * Check if user can add more components
     */
    public function canAddMoreComponents($componentCount)
    {
        $subscription = $this->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        return $subscription->canAddMoreComponents($componentCount);
    }

    /**
     * Check if user can use more storage
     */
    public function canUseMoreStorage($additionalStorageMb)
    {
        $subscription = $this->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        return $subscription->canUseMoreStorage($additionalStorageMb);
    }

    /**
     * Get user subscription plan
     */
    public function getSubscriptionPlan()
    {
        $subscription = $this->activeSubscription();
        return $subscription ? $subscription->subscriptionPlan : null;
    }

    /**
     * Get user subscription status
     */
    public function getSubscriptionStatus()
    {
        $subscription = $this->activeSubscription();
        return $subscription ? $subscription->status : 'none';
    }

    /**
     * Get user cards count
     */
    public function getCardsCount()
    {
        return $this->digitalCards()->count();
    }

    /**
     * Get user active cards count
     */
    public function getActiveCardsCount()
    {
        return $this->digitalCards()->where('is_active', true)->count();
    }

    /**
     * Get user total views
     */
    public function getTotalViews()
    {
        return $this->digitalCards()->sum('view_count');
    }

    /**
     * Get user total appointments
     */
    public function getTotalAppointments()
    {
        return $this->appointments()->count();
    }

    /**
     * Get user pending appointments
     */
    public function getPendingAppointments()
    {
        return $this->appointments()->where('status', 'pending')->count();
    }

    /**
     * Get user completed appointments
     */
    public function getCompletedAppointments()
    {
        return $this->appointments()->where('status', 'completed')->count();
    }

    /**
     * Get user profile statistics
     */
    public function getProfileStats()
    {
        return [
            'total_cards' => $this->getCardsCount(),
            'active_cards' => $this->getActiveCardsCount(),
            'total_views' => $this->getTotalViews(),
            'total_appointments' => $this->getTotalAppointments(),
            'pending_appointments' => $this->getPendingAppointments(),
            'completed_appointments' => $this->getCompletedAppointments(),
            'subscription_status' => $this->getSubscriptionStatus()
        ];
    }
}
