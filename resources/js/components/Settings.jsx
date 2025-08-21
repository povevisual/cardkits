import React, { useState } from 'react';
import { 
    BellIcon,
    ShieldCheckIcon,
    GlobeAltIcon,
    CreditCardIcon,
    CogIcon
} from '@heroicons/react/24/outline';

const Settings = () => {
    const [notifications, setNotifications] = useState({
        email: true,
        push: false,
        marketing: false
    });
    const [privacy, setPrivacy] = useState({
        profileVisibility: 'public',
        analytics: true
    });

    const handleNotificationChange = (key) => {
        setNotifications(prev => ({
            ...prev,
            [key]: !prev[key]
        }));
    };

    const handlePrivacyChange = (key, value) => {
        setPrivacy(prev => ({
            ...prev,
            [key]: value
        }));
    };

    return (
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-900">Settings</h1>
                <p className="mt-2 text-gray-600">Manage your account preferences and settings</p>
            </div>

            <div className="space-y-6">
                {/* Notifications */}
                <div className="card">
                    <div className="flex items-center mb-6">
                        <BellIcon className="h-6 w-6 text-gray-400 mr-3" />
                        <h2 className="text-xl font-semibold text-gray-900">Notifications</h2>
                    </div>
                    
                    <div className="space-y-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-sm font-medium text-gray-900">Email Notifications</h3>
                                <p className="text-sm text-gray-500">Receive updates about your cards via email</p>
                            </div>
                            <button
                                onClick={() => handleNotificationChange('email')}
                                className={`${
                                    notifications.email ? 'bg-primary-600' : 'bg-gray-200'
                                } relative inline-flex h-6 w-11 items-center rounded-full transition-colors`}
                            >
                                <span
                                    className={`${
                                        notifications.email ? 'translate-x-6' : 'translate-x-1'
                                    } inline-block h-4 w-4 transform rounded-full bg-white transition-transform`}
                                />
                            </button>
                        </div>

                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-sm font-medium text-gray-900">Push Notifications</h3>
                                <p className="text-sm text-gray-500">Get instant notifications in your browser</p>
                            </div>
                            <button
                                onClick={() => handleNotificationChange('push')}
                                className={`${
                                    notifications.push ? 'bg-primary-600' : 'bg-gray-200'
                                } relative inline-flex h-6 w-11 items-center rounded-full transition-colors`}
                            >
                                <span
                                    className={`${
                                        notifications.push ? 'translate-x-6' : 'translate-x-1'
                                    } inline-block h-4 w-4 transform rounded-full bg-white transition-transform`}
                                />
                            </button>
                        </div>

                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-sm font-medium text-gray-900">Marketing Emails</h3>
                                <p className="text-sm text-gray-500">Receive promotional content and updates</p>
                            </div>
                            <button
                                onClick={() => handleNotificationChange('marketing')}
                                className={`${
                                    notifications.marketing ? 'bg-primary-600' : 'bg-gray-200'
                                } relative inline-flex h-6 w-11 items-center rounded-full transition-colors`}
                            >
                                <span
                                    className={`${
                                        notifications.marketing ? 'translate-x-6' : 'translate-x-1'
                                    } inline-block h-4 w-4 transform rounded-full bg-white transition-transform`}
                                />
                            </button>
                        </div>
                    </div>
                </div>

                {/* Privacy */}
                <div className="card">
                    <div className="flex items-center mb-6">
                        <ShieldCheckIcon className="h-6 w-6 text-gray-400 mr-3" />
                        <h2 className="text-xl font-semibold text-gray-900">Privacy</h2>
                    </div>
                    
                    <div className="space-y-6">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Profile Visibility
                            </label>
                            <select
                                value={privacy.profileVisibility}
                                onChange={(e) => handlePrivacyChange('profileVisibility', e.target.value)}
                                className="input-field"
                            >
                                <option value="public">Public - Anyone can view your profile</option>
                                <option value="private">Private - Only you can view your profile</option>
                                <option value="contacts">Contacts - Only your contacts can view</option>
                            </select>
                        </div>

                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-sm font-medium text-gray-900">Analytics</h3>
                                <p className="text-sm text-gray-500">Allow us to collect usage data to improve our service</p>
                            </div>
                            <button
                                onClick={() => handlePrivacyChange('analytics', !privacy.analytics)}
                                className={`${
                                    privacy.analytics ? 'bg-primary-600' : 'bg-gray-200'
                                } relative inline-flex h-6 w-11 items-center rounded-full transition-colors`}
                            >
                                <span
                                    className={`${
                                        privacy.analytics ? 'translate-x-6' : 'translate-x-1'
                                    } inline-block h-4 w-4 transform rounded-full bg-white transition-transform`}
                                />
                            </button>
                        </div>
                    </div>
                </div>

                {/* Account */}
                <div className="card">
                    <div className="flex items-center mb-6">
                        <CogIcon className="h-6 w-6 text-gray-400 mr-3" />
                        <h2 className="text-xl font-semibold text-gray-900">Account</h2>
                    </div>
                    
                    <div className="space-y-4">
                        <button className="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-gray-900">Change Password</h3>
                                    <p className="text-sm text-gray-500">Update your account password</p>
                                </div>
                                <div className="text-gray-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <button className="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                                    <p className="text-sm text-gray-500">Add an extra layer of security</p>
                                </div>
                                <div className="text-gray-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <button className="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-gray-900">Export Data</h3>
                                    <p className="text-sm text-gray-500">Download your personal data</p>
                                </div>
                                <div className="text-gray-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                {/* Billing */}
                <div className="card">
                    <div className="flex items-center mb-6">
                        <CreditCardIcon className="h-6 w-6 text-gray-400 mr-3" />
                        <h2 className="text-xl font-semibold text-gray-900">Billing</h2>
                    </div>
                    
                    <div className="space-y-4">
                        <div className="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div>
                                <h3 className="text-sm font-medium text-gray-900">Current Plan</h3>
                                <p className="text-sm text-gray-500">Free Plan</p>
                            </div>
                            <button className="btn-primary">
                                Upgrade Plan
                            </button>
                        </div>

                        <button className="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-gray-900">Payment Methods</h3>
                                    <p className="text-sm text-gray-500">Manage your payment information</p>
                                </div>
                                <div className="text-gray-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <button className="w-full text-left p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-gray-900">Billing History</h3>
                                    <p className="text-sm text-gray-500">View your past invoices</p>
                                </div>
                                <div className="text-gray-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                {/* Danger Zone */}
                <div className="card border-red-200 bg-red-50">
                    <div className="mb-6">
                        <h2 className="text-xl font-semibold text-red-900">Danger Zone</h2>
                        <p className="text-sm text-red-700 mt-1">Irreversible and destructive actions</p>
                    </div>
                    
                    <div className="space-y-4">
                        <button className="w-full text-left p-4 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                            <div className="flex items-center justify-between">
                                <div>
                                    <h3 className="text-sm font-medium text-red-900">Delete Account</h3>
                                    <p className="text-sm text-red-700">Permanently delete your account and all data</p>
                                </div>
                                <div className="text-red-400">
                                    <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Settings;