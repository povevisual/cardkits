import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { useCard } from '../contexts/CardContext';
import { 
    PlusIcon, 
    EyeIcon, 
    PencilIcon, 
    TrashIcon,
    ShareIcon,
    QrCodeIcon,
    ChartBarIcon,
    UsersIcon
} from '@heroicons/react/24/outline';

const Dashboard = () => {
    const { user } = useAuth();
    const { cards, loading, fetchCards, deleteCard } = useCard();
    const [stats, setStats] = useState({
        totalViews: 0,
        totalShares: 0,
        totalContacts: 0
    });

    useEffect(() => {
        if (user) {
            fetchCards();
            // In a real app, you'd fetch stats from API
            setStats({
                totalViews: 1247,
                totalShares: 89,
                totalContacts: 156
            });
        }
    }, [user]);

    const handleDeleteCard = async (id) => {
        if (window.confirm('Are you sure you want to delete this card?')) {
            await deleteCard(id);
        }
    };

    if (!user) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-50">
                <div className="max-w-md w-full space-y-8">
                    <div className="text-center">
                        <h2 className="text-3xl font-bold text-gray-900">Welcome to CardKits.id</h2>
                        <p className="mt-2 text-gray-600">Create your digital business card today</p>
                    </div>
                    <div className="space-y-4">
                        <Link to="/register" className="btn-primary w-full flex justify-center">
                            Get Started
                        </Link>
                        <Link to="/login" className="btn-secondary w-full flex justify-center">
                            Sign In
                        </Link>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {/* Header */}
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p className="mt-2 text-gray-600">Welcome back, {user.name}!</p>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div className="card">
                    <div className="flex items-center">
                        <div className="flex-shrink-0">
                            <EyeIcon className="h-8 w-8 text-primary-600" />
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-500">Total Views</p>
                            <p className="text-2xl font-semibold text-gray-900">{stats.totalViews}</p>
                        </div>
                    </div>
                </div>

                <div className="card">
                    <div className="flex items-center">
                        <div className="flex-shrink-0">
                            <ShareIcon className="h-8 w-8 text-green-600" />
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-500">Total Shares</p>
                            <p className="text-2xl font-semibold text-gray-900">{stats.totalShares}</p>
                        </div>
                    </div>
                </div>

                <div className="card">
                    <div className="flex items-center">
                        <div className="flex-shrink-0">
                            <UsersIcon className="h-8 w-8 text-purple-600" />
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-medium text-gray-500">New Contacts</p>
                            <p className="text-2xl font-semibold text-gray-900">{stats.totalContacts}</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Quick Actions */}
            <div className="mb-8">
                <div className="flex items-center justify-between mb-4">
                    <h2 className="text-xl font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Link to="/builder" className="card hover:shadow-xl transition-shadow duration-200">
                        <div className="flex items-center">
                            <PlusIcon className="h-8 w-8 text-primary-600" />
                            <div className="ml-3">
                                <h3 className="text-lg font-medium text-gray-900">Create New Card</h3>
                                <p className="text-sm text-gray-500">Build a new digital business card</p>
                            </div>
                        </div>
                    </Link>

                    <Link to="/templates" className="card hover:shadow-xl transition-shadow duration-200">
                        <div className="flex items-center">
                            <QrCodeIcon className="h-8 w-8 text-green-600" />
                            <div className="ml-3">
                                <h3 className="text-lg font-medium text-gray-900">Browse Templates</h3>
                                <p className="text-sm text-gray-500">Choose from professional templates</p>
                            </div>
                        </div>
                    </Link>

                    <Link to="/analytics" className="card hover:shadow-xl transition-shadow duration-200">
                        <div className="flex items-center">
                            <ChartBarIcon className="h-8 w-8 text-purple-600" />
                            <div className="ml-3">
                                <h3 className="text-lg font-medium text-gray-900">View Analytics</h3>
                                <p className="text-sm text-gray-500">Track your card performance</p>
                            </div>
                        </div>
                    </Link>

                    <Link to="/settings" className="card hover:shadow-xl transition-shadow duration-200">
                        <div className="flex items-center">
                            <PencilIcon className="h-8 w-8 text-orange-600" />
                            <div className="ml-3">
                                <h3 className="text-lg font-medium text-gray-900">Settings</h3>
                                <p className="text-sm text-gray-500">Manage your account</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            {/* Recent Cards */}
            <div>
                <div className="flex items-center justify-between mb-4">
                    <h2 className="text-xl font-semibold text-gray-900">Your Digital Cards</h2>
                    <Link to="/builder" className="btn-primary">
                        <PlusIcon className="h-4 w-4 mr-2" />
                        Create New
                    </Link>
                </div>

                {loading ? (
                    <div className="text-center py-8">
                        <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600 mx-auto"></div>
                        <p className="mt-2 text-gray-500">Loading your cards...</p>
                    </div>
                ) : cards.length === 0 ? (
                    <div className="text-center py-12">
                        <QrCodeIcon className="mx-auto h-12 w-12 text-gray-400" />
                        <h3 className="mt-2 text-sm font-medium text-gray-900">No cards yet</h3>
                        <p className="mt-1 text-sm text-gray-500">Get started by creating your first digital business card.</p>
                        <div className="mt-6">
                            <Link to="/builder" className="btn-primary">
                                <PlusIcon className="h-4 w-4 mr-2" />
                                Create Your First Card
                            </Link>
                        </div>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {cards.map((card) => (
                            <div key={card.id} className="card hover:shadow-xl transition-shadow duration-200">
                                <div className="flex items-start justify-between">
                                    <div className="flex-1">
                                        <h3 className="text-lg font-semibold text-gray-900">{card.name}</h3>
                                        <p className="text-sm text-gray-500">{card.title}</p>
                                        <p className="text-sm text-gray-400 mt-1">{card.company}</p>
                                    </div>
                                    <div className="flex space-x-2">
                                        <Link
                                            to={`/preview/${card.id}`}
                                            className="p-2 text-gray-400 hover:text-primary-600 transition-colors"
                                        >
                                            <EyeIcon className="h-4 w-4" />
                                        </Link>
                                        <Link
                                            to={`/builder?edit=${card.id}`}
                                            className="p-2 text-gray-400 hover:text-blue-600 transition-colors"
                                        >
                                            <PencilIcon className="h-4 w-4" />
                                        </Link>
                                        <button
                                            onClick={() => handleDeleteCard(card.id)}
                                            className="p-2 text-gray-400 hover:text-red-600 transition-colors"
                                        >
                                            <TrashIcon className="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                                
                                <div className="mt-4 pt-4 border-t border-gray-200">
                                    <div className="flex items-center justify-between text-sm">
                                        <span className="text-gray-500">Views</span>
                                        <span className="font-medium">{card.views || 0}</span>
                                    </div>
                                    <div className="flex items-center justify-between text-sm mt-1">
                                        <span className="text-gray-500">Shares</span>
                                        <span className="font-medium">{card.shares || 0}</span>
                                    </div>
                                </div>

                                <div className="mt-4">
                                    <Link
                                        to={`/preview/${card.id}`}
                                        className="btn-primary w-full text-center"
                                    >
                                        View Card
                                    </Link>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
};

export default Dashboard;