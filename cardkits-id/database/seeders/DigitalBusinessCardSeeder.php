<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SubscriptionPlan;
use App\Models\CardTemplate;
use App\Models\Language;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DigitalBusinessCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createLanguages();
        $this->createPermissions();
        $this->createRoles();
        $this->createSubscriptionPlans();
        $this->createCardTemplates();
        $this->createUsers();
    }

    /**
     * Create languages
     */
    protected function createLanguages()
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'native_name' => 'English',
                'flag' => '🇺🇸',
                'is_active' => true,
                'is_default' => true,
                'is_rtl' => false,
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i',
                'number_format' => '1,234.56',
                'timezone' => 'UTC',
                'currency' => 'USD',
                'sort_order' => 1,
                'show_in_picker' => true
            ],
            [
                'name' => 'Indonesian',
                'code' => 'id',
                'native_name' => 'Bahasa Indonesia',
                'flag' => '🇮🇩',
                'is_active' => true,
                'is_default' => false,
                'is_rtl' => false,
                'date_format' => 'd/m/Y',
                'time_format' => 'H:i',
                'number_format' => '1.234,56',
                'timezone' => 'Asia/Jakarta',
                'currency' => 'IDR',
                'sort_order' => 2,
                'show_in_picker' => true
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'native_name' => 'العربية',
                'flag' => '🇸🇦',
                'is_active' => true,
                'is_default' => false,
                'is_rtl' => true,
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i',
                'number_format' => '١٬٢٣٤٫٥٦',
                'timezone' => 'Asia/Riyadh',
                'currency' => 'SAR',
                'sort_order' => 3,
                'show_in_picker' => true
            ]
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }

        $this->command->info('Languages created successfully.');
    }

    /**
     * Create permissions
     */
    protected function createPermissions()
    {
        $permissions = Permission::getCommonPermissions();

        foreach ($permissions as $slug => $data) {
            Permission::create([
                'name' => $data['name'],
                'slug' => $slug,
                'module' => $data['module'],
                'description' => $data['description'],
                'action' => $data['action'],
                'is_active' => true
            ]);
        }

        $this->command->info('Permissions created successfully.');
    }

    /**
     * Create roles
     */
    protected function createRoles()
    {
        $roles = [
            [
                'name' => 'Free User',
                'slug' => 'free_user',
                'description' => 'Basic user with limited features',
                'type' => 'user',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Premium User',
                'slug' => 'premium_user',
                'description' => 'User with premium features',
                'type' => 'user',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Business User',
                'slug' => 'business_user',
                'description' => 'Business user with advanced features',
                'type' => 'user',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'description' => 'Content moderator',
                'type' => 'moderator',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Support',
                'slug' => 'support',
                'description' => 'Customer support team',
                'type' => 'support',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Analyst',
                'slug' => 'analyst',
                'description' => 'Data analyst',
                'type' => 'analyst',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'System administrator',
                'type' => 'admin',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Super Administrator',
                'slug' => 'super_admin',
                'description' => 'Super system administrator',
                'type' => 'super_admin',
                'is_active' => true,
                'sort_order' => 8
            ]
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        $this->command->info('Roles created successfully.');
    }

    /**
     * Create subscription plans
     */
    protected function createSubscriptionPlans()
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started',
                'type' => 'free',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'trial_days' => 0,
                'is_popular' => false,
                'max_cards' => 1,
                'max_components' => 5,
                'max_storage_mb' => 100,
                'custom_domain' => false,
                'white_label' => false,
                'advanced_analytics' => false,
                'priority_support' => false,
                'template_access' => ['basic'],
                'premium_templates' => false,
                'custom_css' => false,
                'integrations' => ['basic'],
                'payment_gateways' => ['stripe'],
                'calendar_integration' => false,
                'api_access' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Great for small businesses',
                'type' => 'basic',
                'price' => 9.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'trial_days' => 14,
                'is_popular' => false,
                'max_cards' => 5,
                'max_components' => 20,
                'max_storage_mb' => 500,
                'custom_domain' => false,
                'white_label' => false,
                'advanced_analytics' => false,
                'priority_support' => false,
                'template_access' => ['basic', 'premium'],
                'premium_templates' => true,
                'custom_css' => false,
                'integrations' => ['basic', 'medium'],
                'payment_gateways' => ['stripe', 'paypal'],
                'calendar_integration' => true,
                'api_access' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Perfect for growing businesses',
                'type' => 'pro',
                'price' => 29.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'trial_days' => 14,
                'is_popular' => true,
                'max_cards' => 25,
                'max_components' => 100,
                'max_storage_mb' => 2000,
                'custom_domain' => true,
                'white_label' => false,
                'advanced_analytics' => true,
                'priority_support' => true,
                'template_access' => ['basic', 'premium', 'enterprise'],
                'premium_templates' => true,
                'custom_css' => true,
                'integrations' => ['basic', 'medium', 'advanced'],
                'payment_gateways' => ['stripe', 'paypal', 'razorpay'],
                'calendar_integration' => true,
                'api_access' => true,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large organizations',
                'type' => 'enterprise',
                'price' => 99.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'trial_days' => 30,
                'is_popular' => false,
                'max_cards' => -1, // Unlimited
                'max_components' => -1, // Unlimited
                'max_storage_mb' => -1, // Unlimited
                'custom_domain' => true,
                'white_label' => true,
                'advanced_analytics' => true,
                'priority_support' => true,
                'template_access' => ['basic', 'premium', 'enterprise', 'custom'],
                'premium_templates' => true,
                'custom_css' => true,
                'integrations' => ['basic', 'medium', 'advanced', 'custom'],
                'payment_gateways' => ['stripe', 'paypal', 'razorpay'],
                'calendar_integration' => true,
                'api_access' => true,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4
            ]
        ];

        foreach ($plans as $planData) {
            SubscriptionPlan::create($planData);
        }

        $this->command->info('Subscription plans created successfully.');
    }

    /**
     * Create card templates
     */
    protected function createCardTemplates()
    {
        $templates = [
            [
                'name' => 'Classic Business',
                'slug' => 'classic-business',
                'description' => 'Professional and clean design for business professionals',
                'category' => 'business',
                'color_schemes' => [
                    'blue' => ['primary' => '#2563eb', 'secondary' => '#1e40af', 'accent' => '#3b82f6'],
                    'green' => ['primary' => '#059669', 'secondary' => '#047857', 'accent' => '#10b981'],
                    'purple' => ['primary' => '#7c3aed', 'secondary' => '#6d28d9', 'accent' => '#8b5cf6'],
                    'gray' => ['primary' => '#374151', 'secondary' => '#1f2937', 'accent' => '#6b7280']
                ],
                'layout_config' => [
                    'header' => ['profile_photo' => true, 'cover_photo' => false],
                    'sections' => ['contact', 'social', 'about', 'services'],
                    'footer' => ['logo' => true, 'copyright' => true]
                ],
                'component_config' => [
                    'profile' => ['show_name' => true, 'show_title' => true, 'show_company' => true],
                    'contact' => ['show_email' => true, 'show_phone' => true, 'show_address' => true],
                    'social' => ['show_icons' => true, 'show_labels' => false]
                ],
                'is_active' => true,
                'is_premium' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Modern Creative',
                'slug' => 'modern-creative',
                'description' => 'Contemporary design with creative elements',
                'category' => 'creative',
                'color_schemes' => [
                    'gradient' => ['primary' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'secondary' => '#4c1d95', 'accent' => '#a855f7'],
                    'sunset' => ['primary' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'secondary' => '#dc2626', 'accent' => '#f97316'],
                    'ocean' => ['primary' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'secondary' => '#0891b2', 'accent' => '#06b6d4']
                ],
                'layout_config' => [
                    'header' => ['profile_photo' => true, 'cover_photo' => true],
                    'sections' => ['hero', 'portfolio', 'contact', 'social'],
                    'footer' => ['logo' => false, 'copyright' => true]
                ],
                'component_config' => [
                    'profile' => ['show_name' => true, 'show_title' => true, 'show_bio' => true],
                    'portfolio' => ['show_gallery' => true, 'show_projects' => true],
                    'social' => ['show_icons' => true, 'show_labels' => true]
                ],
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'description' => 'Clean and simple design focusing on content',
                'category' => 'minimal',
                'color_schemes' => [
                    'monochrome' => ['primary' => '#000000', 'secondary' => '#333333', 'accent' => '#666666'],
                    'white' => ['primary' => '#ffffff', 'secondary' => '#f3f4f6', 'accent' => '#d1d5db'],
                    'sepia' => ['primary' => '#f5f5dc', 'secondary' => '#e8dcc4', 'accent' => '#d2b48c']
                ],
                'layout_config' => [
                    'header' => ['profile_photo' => true, 'cover_photo' => false],
                    'sections' => ['intro', 'contact', 'social'],
                    'footer' => ['logo' => false, 'copyright' => false]
                ],
                'component_config' => [
                    'profile' => ['show_name' => true, 'show_title' => true, 'show_bio' => false],
                    'contact' => ['show_email' => true, 'show_phone' => false, 'show_address' => false],
                    'social' => ['show_icons' => true, 'show_labels' => false]
                ],
                'is_active' => true,
                'is_premium' => false,
                'sort_order' => 3
            ],
            [
                'name' => 'Tech Startup',
                'slug' => 'tech-startup',
                'description' => 'Modern design perfect for tech companies and startups',
                'category' => 'tech',
                'color_schemes' => [
                    'dark' => ['primary' => '#0f172a', 'secondary' => '#1e293b', 'accent' => '#3b82f6'],
                    'neon' => ['primary' => '#0f0f23', 'secondary' => '#1a1a2e', 'accent' => '#00ff88'],
                    'cyber' => ['primary' => '#1a1a1a', 'secondary' => '#2d2d2d', 'accent' => '#00d4ff']
                ],
                'layout_config' => [
                    'header' => ['profile_photo' => true, 'cover_photo' => true],
                    'sections' => ['hero', 'features', 'team', 'contact', 'social'],
                    'footer' => ['logo' => true, 'copyright' => true]
                ],
                'component_config' => [
                    'profile' => ['show_name' => true, 'show_title' => true, 'show_company' => true],
                    'features' => ['show_icons' => true, 'show_descriptions' => true],
                    'team' => ['show_photos' => true, 'show_roles' => true],
                    'social' => ['show_icons' => true, 'show_labels' => false]
                ],
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Healthcare Professional',
                'slug' => 'healthcare-professional',
                'description' => 'Trustworthy design for healthcare professionals',
                'category' => 'healthcare',
                'color_schemes' => [
                    'medical' => ['primary' => '#059669', 'secondary' => '#047857', 'accent' => '#10b981'],
                    'blue' => ['primary' => '#2563eb', 'secondary' => '#1e40af', 'accent' => '#3b82f6'],
                    'teal' => ['primary' => '#0d9488', 'secondary' => '#0f766e', 'accent' => '#14b8a6']
                ],
                'layout_config' => [
                    'header' => ['profile_photo' => true, 'cover_photo' => false],
                    'sections' => ['credentials', 'services', 'appointments', 'contact', 'social'],
                    'footer' => ['logo' => true, 'copyright' => true]
                ],
                'component_config' => [
                    'profile' => ['show_name' => true, 'show_title' => true, 'show_credentials' => true],
                    'services' => ['show_icons' => true, 'show_descriptions' => true],
                    'appointments' => ['show_calendar' => true, 'show_booking' => true],
                    'social' => ['show_icons' => true, 'show_labels' => false]
                ],
                'is_active' => true,
                'is_premium' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($templates as $templateData) {
            CardTemplate::create($templateData);
        }

        $this->command->info('Card templates created successfully.');
    }

    /**
     * Create users
     */
    protected function createUsers()
    {
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cardkits.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        $superAdmin->assignRole('super_admin');

        // Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        $user->assignRole('free_user');

        // Create premium user
        $premiumUser = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        $premiumUser->assignRole('premium_user');

        // Create business user
        $businessUser = User::create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        $businessUser->assignRole('business_user');

        $this->command->info('Users created successfully.');
        $this->command->info('Super Admin: admin@cardkits.com / password');
        $this->command->info('Regular User: john@example.com / password');
        $this->command->info('Premium User: jane@example.com / password');
        $this->command->info('Business User: business@example.com / password');
    }
}
