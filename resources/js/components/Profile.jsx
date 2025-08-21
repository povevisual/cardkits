import React, { useState } from 'react';
import { useAuth } from '../contexts/AuthContext';
import { 
    UserCircleIcon,
    PhotoIcon,
    PencilIcon
} from '@heroicons/react/24/outline';

const Profile = () => {
    const { user } = useAuth();
    const [isEditing, setIsEditing] = useState(false);
    const [formData, setFormData] = useState({
        name: user?.name || '',
        email: user?.email || '',
        bio: user?.bio || ''
    });
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState('');

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        
        try {
            // In a real app, you'd make an API call here
            await new Promise(resolve => setTimeout(resolve, 1000));
            setMessage('Profile updated successfully!');
            setIsEditing(false);
        } catch (error) {
            setMessage('Failed to update profile. Please try again.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-900">Profile</h1>
                <p className="mt-2 text-gray-600">Manage your account information</p>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* Profile Card */}
                <div className="lg:col-span-2">
                    <div className="card">
                        <div className="flex items-center justify-between mb-6">
                            <h2 className="text-xl font-semibold text-gray-900">Personal Information</h2>
                            <button
                                onClick={() => setIsEditing(!isEditing)}
                                className="btn-secondary"
                            >
                                <PencilIcon className="h-4 w-4 mr-2" />
                                {isEditing ? 'Cancel' : 'Edit'}
                            </button>
                        </div>

                        {message && (
                            <div className={`mb-4 p-4 rounded-md ${
                                message.includes('successfully') 
                                    ? 'bg-green-50 border border-green-200 text-green-800' 
                                    : 'bg-red-50 border border-red-200 text-red-800'
                            }`}>
                                {message}
                            </div>
                        )}

                        <form onSubmit={handleSubmit}>
                            <div className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleInputChange}
                                        disabled={!isEditing}
                                        className={`input-field ${!isEditing ? 'bg-gray-50' : ''}`}
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleInputChange}
                                        disabled={!isEditing}
                                        className={`input-field ${!isEditing ? 'bg-gray-50' : ''}`}
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Bio
                                    </label>
                                    <textarea
                                        name="bio"
                                        value={formData.bio}
                                        onChange={handleInputChange}
                                        disabled={!isEditing}
                                        rows={4}
                                        className={`input-field ${!isEditing ? 'bg-gray-50' : ''}`}
                                        placeholder="Tell us about yourself..."
                                    />
                                </div>

                                {isEditing && (
                                    <div className="flex space-x-4">
                                        <button
                                            type="submit"
                                            disabled={loading}
                                            className="btn-primary"
                                        >
                                            {loading ? 'Saving...' : 'Save Changes'}
                                        </button>
                                        <button
                                            type="button"
                                            onClick={() => setIsEditing(false)}
                                            className="btn-secondary"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                )}
                            </div>
                        </form>
                    </div>
                </div>

                {/* Sidebar */}
                <div className="space-y-6">
                    {/* Profile Photo */}
                    <div className="card">
                        <h3 className="text-lg font-semibold text-gray-900 mb-4">Profile Photo</h3>
                        <div className="flex items-center space-x-4">
                            <div className="w-20 h-20 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                {user?.photo ? (
                                    <img
                                        src={user.photo}
                                        alt="Profile"
                                        className="w-full h-full object-cover"
                                    />
                                ) : (
                                    <UserCircleIcon className="h-12 w-12 text-gray-400" />
                                )}
                            </div>
                            <div>
                                <button className="btn-secondary">
                                    <PhotoIcon className="h-4 w-4 mr-2" />
                                    Change Photo
                                </button>
                                <p className="text-sm text-gray-500 mt-1">
                                    JPG, PNG or GIF. Max 2MB.
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Account Stats */}
                    <div className="card">
                        <h3 className="text-lg font-semibold text-gray-900 mb-4">Account Statistics</h3>
                        <div className="space-y-3">
                            <div className="flex justify-between">
                                <span className="text-gray-600">Member since</span>
                                <span className="font-semibold">January 2024</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Cards created</span>
                                <span className="font-semibold">5</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Total views</span>
                                <span className="font-semibold">1,247</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Total shares</span>
                                <span className="font-semibold">89</span>
                            </div>
                        </div>
                    </div>

                    {/* Quick Actions */}
                    <div className="card">
                        <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div className="space-y-3">
                            <button className="w-full btn-secondary text-left">
                                Change Password
                            </button>
                            <button className="w-full btn-secondary text-left">
                                Export Data
                            </button>
                            <button className="w-full btn-secondary text-left text-red-600 hover:text-red-700">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Profile;