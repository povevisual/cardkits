<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BioLink;
use App\Models\BioLinkItem;
use App\Models\BioLinkSocialMedia;

class BioLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample user if none exists
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample bio links
        $bioLinks = [
            [
                'title' => 'John Doe - Developer & Designer',
                'description' => 'Full-stack developer passionate about creating beautiful and functional web applications.',
                'theme_color' => '#1a365d',
                'text_color' => '#ffffff',
                'button_color' => '#3182ce',
                'button_text_color' => '#ffffff',
                'font_family' => 'Inter',
                'show_social_icons' => true,
                'show_analytics' => true,
                'slug' => 'john-doe',
                'is_active' => true,
                'items' => [
                    [
                        'title' => 'Portfolio Website',
                        'url' => 'https://johndoe.dev',
                        'type' => 'link',
                        'icon' => 'fas fa-briefcase',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'title' => 'GitHub Profile',
                        'url' => 'https://github.com/johndoe',
                        'type' => 'link',
                        'icon' => 'fab fa-github',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'title' => 'Resume (PDF)',
                        'url' => 'https://johndoe.dev/resume.pdf',
                        'type' => 'file',
                        'icon' => 'fas fa-file-pdf',
                        'order' => 3,
                        'is_active' => true,
                    ],
                    [
                        'title' => 'Contact Me',
                        'url' => 'mailto:john@johndoe.dev',
                        'type' => 'email',
                        'icon' => 'fas fa-envelope',
                        'order' => 4,
                        'is_active' => true,
                    ],
                ],
                'social_media' => [
                    [
                        'platform' => 'twitter',
                        'username' => 'johndoe',
                        'url' => 'https://twitter.com/johndoe',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'platform' => 'linkedin',
                        'username' => 'johndoe',
                        'url' => 'https://linkedin.com/in/johndoe',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'platform' => 'instagram',
                        'username' => 'johndoe',
                        'url' => 'https://instagram.com/johndoe',
                        'order' => 3,
                        'is_active' => true,
                    ],
                ]
            ],
            [
                'title' => 'Sarah Smith - Creative Designer',
                'description' => 'Passionate about creating stunning visual experiences and digital art.',
                'theme_color' => '#7c3aed',
                'text_color' => '#ffffff',
                'button_color' => '#ec4899',
                'button_text_color' => '#ffffff',
                'font_family' => 'Poppins',
                'show_social_icons' => true,
                'show_analytics' => true,
                'slug' => 'sarah-smith',
                'is_active' => true,
                'items' => [
                    [
                        'title' => 'Behance Portfolio',
                        'url' => 'https://behance.net/sarahsmith',
                        'type' => 'link',
                        'icon' => 'fab fa-behance',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'title' => 'Dribbble Shots',
                        'url' => 'https://dribbble.com/sarahsmith',
                        'type' => 'link',
                        'icon' => 'fab fa-dribbble',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'title' => 'Design Blog',
                        'url' => 'https://sarahsmith.design/blog',
                        'type' => 'link',
                        'icon' => 'fas fa-blog',
                        'order' => 3,
                        'is_active' => true,
                    ],
                ],
                'social_media' => [
                    [
                        'platform' => 'instagram',
                        'username' => 'sarahsmith.design',
                        'url' => 'https://instagram.com/sarahsmith.design',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'platform' => 'pinterest',
                        'username' => 'sarahsmith',
                        'url' => 'https://pinterest.com/sarahsmith',
                        'order' => 2,
                        'is_active' => true,
                    ],
                ]
            ]
        ];

        foreach ($bioLinks as $bioLinkData) {
            $items = $bioLinkData['items'];
            $socialMedia = $bioLinkData['social_media'];
            
            unset($bioLinkData['items'], $bioLinkData['social_media']);
            $bioLinkData['user_id'] = $user->id;
            
            $bioLink = BioLink::create($bioLinkData);

            // Create bio link items
            foreach ($items as $itemData) {
                $itemData['bio_link_id'] = $bioLink->id;
                BioLinkItem::create($itemData);
            }

            // Create social media links
            foreach ($socialMedia as $socialData) {
                $socialData['bio_link_id'] = $bioLink->id;
                BioLinkSocialMedia::create($socialData);
            }
        }
    }
}