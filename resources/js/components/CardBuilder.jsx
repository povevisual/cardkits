import React, { useState, useEffect } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';
import { useCard } from '../contexts/CardContext';
import { 
    ArrowLeftIcon,
    EyeIcon,
    PhotoIcon,
    GlobeAltIcon,
    PhoneIcon,
    EnvelopeIcon,
    MapPinIcon,
    BuildingOfficeIcon
} from '@heroicons/react/24/outline';

const CardBuilder = () => {
    const navigate = useNavigate();
    const [searchParams] = useSearchParams();
    const { createCard, updateCard, getCard, currentCard, loading } = useCard();
    const [formData, setFormData] = useState({
        name: '',
        title: '',
        company: '',
        email: '',
        phone: '',
        website: '',
        address: '',
        bio: '',
        photo: null,
        template: 'modern',
        color_scheme: 'blue'
    });
    const [previewMode, setPreviewMode] = useState(false);
    const [errors, setErrors] = useState({});

    const editId = searchParams.get('edit');

    useEffect(() => {
        if (editId) {
            getCard(editId);
        }
    }, [editId]);

    useEffect(() => {
        if (currentCard && editId) {
            setFormData({
                name: currentCard.name || '',
                title: currentCard.title || '',
                company: currentCard.company || '',
                email: currentCard.email || '',
                phone: currentCard.phone || '',
                website: currentCard.website || '',
                address: currentCard.address || '',
                bio: currentCard.bio || '',
                photo: currentCard.photo || null,
                template: currentCard.template || 'modern',
                color_scheme: currentCard.color_scheme || 'blue'
            });
        }
    }, [currentCard, editId]);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
        
        // Clear error when user starts typing
        if (errors[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ''
            }));
        }
    };

    const handlePhotoChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                setFormData(prev => ({
                    ...prev,
                    photo: reader.result
                }));
            };
            reader.readAsDataURL(file);
        }
    };

    const validateForm = () => {
        const newErrors = {};
        
        if (!formData.name.trim()) {
            newErrors.name = 'Name is required';
        }
        
        if (!formData.email.trim()) {
            newErrors.email = 'Email is required';
        } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
            newErrors.email = 'Email is invalid';
        }
        
        if (!formData.title.trim()) {
            newErrors.title = 'Job title is required';
        }
        
        if (!formData.company.trim()) {
            newErrors.company = 'Company is required';
        }

        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }

        try {
            if (editId) {
                await updateCard(editId, formData);
            } else {
                await createCard(formData);
            }
            navigate('/');
        } catch (error) {
            console.error('Error saving card:', error);
        }
    };

    const templates = [
        { id: 'modern', name: 'Modern', preview: 'bg-gradient-to-r from-blue-500 to-purple-600' },
        { id: 'classic', name: 'Classic', preview: 'bg-gradient-to-r from-gray-800 to-gray-900' },
        { id: 'creative', name: 'Creative', preview: 'bg-gradient-to-r from-green-400 to-blue-500' },
        { id: 'minimal', name: 'Minimal', preview: 'bg-gradient-to-r from-white to-gray-100 border-2 border-gray-300' }
    ];

    const colorSchemes = [
        { id: 'blue', name: 'Blue', class: 'from-blue-500 to-blue-600' },
        { id: 'green', name: 'Green', class: 'from-green-500 to-green-600' },
        { id: 'purple', name: 'Purple', class: 'from-purple-500 to-purple-600' },
        { id: 'orange', name: 'Orange', class: 'from-orange-500 to-orange-600' },
        { id: 'red', name: 'Red', class: 'from-red-500 to-red-600' }
    ];

    return (
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-6">
                <button
                    onClick={() => navigate('/')}
                    className="flex items-center text-gray-600 hover:text-gray-900"
                >
                    <ArrowLeftIcon className="h-4 w-4 mr-2" />
                    Back to Dashboard
                </button>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {/* Form Section */}
                <div className="space-y-6">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">
                            {editId ? 'Edit Card' : 'Create New Card'}
                        </h1>
                        <p className="mt-2 text-gray-600">
                            Build your professional digital business card
                        </p>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Personal Information */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                            
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name *
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleInputChange}
                                        className={`input-field ${errors.name ? 'border-red-500' : ''}`}
                                        placeholder="John Doe"
                                    />
                                    {errors.name && <p className="mt-1 text-sm text-red-600">{errors.name}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Job Title *
                                    </label>
                                    <input
                                        type="text"
                                        name="title"
                                        value={formData.title}
                                        onChange={handleInputChange}
                                        className={`input-field ${errors.title ? 'border-red-500' : ''}`}
                                        placeholder="Software Engineer"
                                    />
                                    {errors.title && <p className="mt-1 text-sm text-red-600">{errors.title}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Company *
                                    </label>
                                    <input
                                        type="text"
                                        name="company"
                                        value={formData.company}
                                        onChange={handleInputChange}
                                        className={`input-field ${errors.company ? 'border-red-500' : ''}`}
                                        placeholder="Tech Corp"
                                    />
                                    {errors.company && <p className="mt-1 text-sm text-red-600">{errors.company}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Email *
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleInputChange}
                                        className={`input-field ${errors.email ? 'border-red-500' : ''}`}
                                        placeholder="john@example.com"
                                    />
                                    {errors.email && <p className="mt-1 text-sm text-red-600">{errors.email}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Phone
                                    </label>
                                    <input
                                        type="tel"
                                        name="phone"
                                        value={formData.phone}
                                        onChange={handleInputChange}
                                        className="input-field"
                                        placeholder="+1 (555) 123-4567"
                                    />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Website
                                    </label>
                                    <input
                                        type="url"
                                        name="website"
                                        value={formData.website}
                                        onChange={handleInputChange}
                                        className="input-field"
                                        placeholder="https://example.com"
                                    />
                                </div>
                            </div>

                            <div className="mt-4">
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Address
                                </label>
                                <input
                                    type="text"
                                    name="address"
                                    value={formData.address}
                                    onChange={handleInputChange}
                                    className="input-field"
                                    placeholder="123 Business St, City, State 12345"
                                />
                            </div>

                            <div className="mt-4">
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Bio
                                </label>
                                <textarea
                                    name="bio"
                                    value={formData.bio}
                                    onChange={handleInputChange}
                                    rows={3}
                                    className="input-field"
                                    placeholder="Tell people about yourself and your expertise..."
                                />
                            </div>
                        </div>

                        {/* Photo Upload */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Profile Photo</h3>
                            
                            <div className="flex items-center space-x-4">
                                <div className="w-20 h-20 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                    {formData.photo ? (
                                        <img
                                            src={formData.photo}
                                            alt="Profile"
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <PhotoIcon className="h-8 w-8 text-gray-400" />
                                    )}
                                </div>
                                
                                <div>
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={handlePhotoChange}
                                        className="hidden"
                                        id="photo-upload"
                                    />
                                    <label
                                        htmlFor="photo-upload"
                                        className="btn-secondary cursor-pointer"
                                    >
                                        Upload Photo
                                    </label>
                                    <p className="mt-1 text-sm text-gray-500">
                                        Recommended: Square image, 400x400px or larger
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Template Selection */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Template</h3>
                            
                            <div className="grid grid-cols-2 gap-4">
                                {templates.map((template) => (
                                    <div
                                        key={template.id}
                                        className={`relative cursor-pointer rounded-lg border-2 p-4 ${
                                            formData.template === template.id
                                                ? 'border-primary-500 bg-primary-50'
                                                : 'border-gray-200 hover:border-gray-300'
                                        }`}
                                        onClick={() => setFormData(prev => ({ ...prev, template: template.id }))}
                                    >
                                        <div className={`h-16 rounded ${template.preview} mb-2`}></div>
                                        <p className="text-sm font-medium text-gray-900">{template.name}</p>
                                        {formData.template === template.id && (
                                            <div className="absolute top-2 right-2 w-4 h-4 bg-primary-500 rounded-full flex items-center justify-center">
                                                <div className="w-2 h-2 bg-white rounded-full"></div>
                                            </div>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Color Scheme */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Color Scheme</h3>
                            
                            <div className="flex space-x-4">
                                {colorSchemes.map((scheme) => (
                                    <div
                                        key={scheme.id}
                                        className={`relative cursor-pointer ${
                                            formData.color_scheme === scheme.id
                                                ? 'ring-2 ring-primary-500 ring-offset-2'
                                                : ''
                                        }`}
                                        onClick={() => setFormData(prev => ({ ...prev, color_scheme: scheme.id }))}
                                    >
                                        <div className={`w-12 h-12 rounded-lg bg-gradient-to-r ${scheme.class}`}></div>
                                        <p className="text-xs text-center mt-1 text-gray-600">{scheme.name}</p>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Submit Button */}
                        <div className="flex space-x-4">
                            <button
                                type="submit"
                                disabled={loading}
                                className="btn-primary flex-1"
                            >
                                {loading ? 'Saving...' : (editId ? 'Update Card' : 'Create Card')}
                            </button>
                            
                            <button
                                type="button"
                                onClick={() => setPreviewMode(!previewMode)}
                                className="btn-secondary"
                            >
                                <EyeIcon className="h-4 w-4 mr-2" />
                                Preview
                            </button>
                        </div>
                    </form>
                </div>

                {/* Preview Section */}
                <div className="lg:sticky lg:top-8">
                    <div className="card">
                        <h3 className="text-lg font-semibold text-gray-900 mb-4">Preview</h3>
                        
                        <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div className={`bg-gradient-to-r ${colorSchemes.find(c => c.id === formData.color_scheme)?.class || 'from-blue-500 to-blue-600'} p-6 text-white`}>
                                <div className="flex items-center space-x-4">
                                    <div className="w-16 h-16 rounded-full overflow-hidden bg-white/20 flex items-center justify-center">
                                        {formData.photo ? (
                                            <img
                                                src={formData.photo}
                                                alt="Profile"
                                                className="w-full h-full object-cover"
                                            />
                                        ) : (
                                            <PhotoIcon className="h-8 w-8 text-white/70" />
                                        )}
                                    </div>
                                    <div>
                                        <h2 className="text-xl font-bold">{formData.name || 'Your Name'}</h2>
                                        <p className="text-white/90">{formData.title || 'Job Title'}</p>
                                        <p className="text-white/80">{formData.company || 'Company'}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="p-6 space-y-4">
                                {formData.email && (
                                    <div className="flex items-center space-x-3">
                                        <EnvelopeIcon className="h-5 w-5 text-gray-400" />
                                        <span className="text-gray-700">{formData.email}</span>
                                    </div>
                                )}
                                
                                {formData.phone && (
                                    <div className="flex items-center space-x-3">
                                        <PhoneIcon className="h-5 w-5 text-gray-400" />
                                        <span className="text-gray-700">{formData.phone}</span>
                                    </div>
                                )}
                                
                                {formData.website && (
                                    <div className="flex items-center space-x-3">
                                        <GlobeAltIcon className="h-5 w-5 text-gray-400" />
                                        <span className="text-gray-700">{formData.website}</span>
                                    </div>
                                )}
                                
                                {formData.address && (
                                    <div className="flex items-center space-x-3">
                                        <MapPinIcon className="h-5 w-5 text-gray-400" />
                                        <span className="text-gray-700">{formData.address}</span>
                                    </div>
                                )}
                                
                                {formData.bio && (
                                    <div className="pt-4 border-t border-gray-200">
                                        <p className="text-gray-600 text-sm">{formData.bio}</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CardBuilder;