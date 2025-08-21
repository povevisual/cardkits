import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { useCard } from '../contexts/CardContext';
import { 
    ShareIcon, 
    QrCodeIcon, 
    ArrowLeftIcon,
    PhoneIcon,
    EnvelopeIcon,
    GlobeAltIcon,
    MapPinIcon,
    PhotoIcon
} from '@heroicons/react/24/outline';

const CardPreview = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const { getCard, currentCard, loading } = useCard();
    const [showQR, setShowQR] = useState(false);
    const [shareMenuOpen, setShareMenuOpen] = useState(false);

    useEffect(() => {
        if (id) {
            getCard(id);
        }
    }, [id]);

    const handleShare = async (platform) => {
        const url = window.location.href;
        const text = `Check out ${currentCard?.name}'s digital business card`;
        
        let shareUrl = '';
        
        switch (platform) {
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
                break;
            case 'telegram':
                shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
                break;
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'linkedin':
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
                break;
            case 'copy':
                try {
                    await navigator.clipboard.writeText(url);
                    alert('Link copied to clipboard!');
                } catch (err) {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Link copied to clipboard!');
                }
                setShareMenuOpen(false);
                return;
            default:
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank');
        }
        setShareMenuOpen(false);
    };

    const downloadVCard = () => {
        if (!currentCard) return;
        
        const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${currentCard.name}
ORG:${currentCard.company}
TITLE:${currentCard.title}
EMAIL:${currentCard.email}
TEL:${currentCard.phone || ''}
URL:${currentCard.website || ''}
ADR:;;${currentCard.address || ''};;;;
NOTE:${currentCard.bio || ''}
END:VCARD`;
        
        const blob = new Blob([vcard], { type: 'text/vcard' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${currentCard.name.replace(/\s+/g, '_')}.vcf`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    };

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-50">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
                    <p className="mt-4 text-gray-600">Loading card...</p>
                </div>
            </div>
        );
    }

    if (!currentCard) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-gray-50">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-gray-900 mb-4">Card Not Found</h2>
                    <p className="text-gray-600 mb-6">The digital business card you're looking for doesn't exist.</p>
                    <button
                        onClick={() => navigate('/')}
                        className="btn-primary"
                    >
                        Go Home
                    </button>
                </div>
            </div>
        );
    }

    const colorSchemes = {
        blue: 'from-blue-500 to-blue-600',
        green: 'from-green-500 to-green-600',
        purple: 'from-purple-500 to-purple-600',
        orange: 'from-orange-500 to-orange-600',
        red: 'from-red-500 to-red-600'
    };

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Header */}
            <div className="bg-white shadow-sm border-b border-gray-200">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div className="flex items-center justify-between">
                        <button
                            onClick={() => navigate('/')}
                            className="flex items-center text-gray-600 hover:text-gray-900"
                        >
                            <ArrowLeftIcon className="h-4 w-4 mr-2" />
                            Back
                        </button>
                        
                        <div className="flex items-center space-x-4">
                            <button
                                onClick={() => setShowQR(!showQR)}
                                className="btn-secondary"
                            >
                                <QrCodeIcon className="h-4 w-4 mr-2" />
                                QR Code
                            </button>
                            
                            <div className="relative">
                                <button
                                    onClick={() => setShareMenuOpen(!shareMenuOpen)}
                                    className="btn-primary"
                                >
                                    <ShareIcon className="h-4 w-4 mr-2" />
                                    Share
                                </button>
                                
                                {shareMenuOpen && (
                                    <div className="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                        <div className="py-1">
                                            <button
                                                onClick={() => handleShare('whatsapp')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                WhatsApp
                                            </button>
                                            <button
                                                onClick={() => handleShare('telegram')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                Telegram
                                            </button>
                                            <button
                                                onClick={() => handleShare('twitter')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                Twitter
                                            </button>
                                            <button
                                                onClick={() => handleShare('facebook')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                Facebook
                                            </button>
                                            <button
                                                onClick={() => handleShare('linkedin')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                LinkedIn
                                            </button>
                                            <button
                                                onClick={() => handleShare('copy')}
                                                className="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                Copy Link
                                            </button>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Main Card */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-xl shadow-lg overflow-hidden">
                            {/* Header with gradient */}
                            <div className={`bg-gradient-to-r ${colorSchemes[currentCard.color_scheme] || colorSchemes.blue} p-8 text-white`}>
                                <div className="flex items-center space-x-6">
                                    <div className="w-24 h-24 rounded-full overflow-hidden bg-white/20 flex items-center justify-center">
                                        {currentCard.photo ? (
                                            <img
                                                src={currentCard.photo}
                                                alt={currentCard.name}
                                                className="w-full h-full object-cover"
                                            />
                                        ) : (
                                            <PhotoIcon className="h-12 w-12 text-white/70" />
                                        )}
                                    </div>
                                    <div>
                                        <h1 className="text-3xl font-bold">{currentCard.name}</h1>
                                        <p className="text-xl text-white/90 mt-1">{currentCard.title}</p>
                                        <p className="text-lg text-white/80 mt-1">{currentCard.company}</p>
                                    </div>
                                </div>
                            </div>
                            
                            {/* Contact Information */}
                            <div className="p-8 space-y-6">
                                {currentCard.email && (
                                    <div className="flex items-center space-x-4">
                                        <div className="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <EnvelopeIcon className="h-5 w-5 text-primary-600" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500">Email</p>
                                            <a 
                                                href={`mailto:${currentCard.email}`}
                                                className="text-gray-900 hover:text-primary-600 transition-colors"
                                            >
                                                {currentCard.email}
                                            </a>
                                        </div>
                                    </div>
                                )}
                                
                                {currentCard.phone && (
                                    <div className="flex items-center space-x-4">
                                        <div className="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <PhoneIcon className="h-5 w-5 text-green-600" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500">Phone</p>
                                            <a 
                                                href={`tel:${currentCard.phone}`}
                                                className="text-gray-900 hover:text-green-600 transition-colors"
                                            >
                                                {currentCard.phone}
                                            </a>
                                        </div>
                                    </div>
                                )}
                                
                                {currentCard.website && (
                                    <div className="flex items-center space-x-4">
                                        <div className="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <GlobeAltIcon className="h-5 w-5 text-purple-600" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500">Website</p>
                                            <a 
                                                href={currentCard.website}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="text-gray-900 hover:text-purple-600 transition-colors"
                                            >
                                                {currentCard.website}
                                            </a>
                                        </div>
                                    </div>
                                )}
                                
                                {currentCard.address && (
                                    <div className="flex items-center space-x-4">
                                        <div className="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <MapPinIcon className="h-5 w-5 text-orange-600" />
                                        </div>
                                        <div>
                                            <p className="text-sm text-gray-500">Address</p>
                                            <p className="text-gray-900">{currentCard.address}</p>
                                        </div>
                                    </div>
                                )}
                                
                                {currentCard.bio && (
                                    <div className="pt-6 border-t border-gray-200">
                                        <h3 className="text-lg font-semibold text-gray-900 mb-2">About</h3>
                                        <p className="text-gray-600 leading-relaxed">{currentCard.bio}</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* QR Code */}
                        {showQR && (
                            <div className="card">
                                <h3 className="text-lg font-semibold text-gray-900 mb-4">QR Code</h3>
                                <div className="flex justify-center">
                                    <div className="w-48 h-48 bg-white p-4 rounded-lg border">
                                        {/* In a real app, you'd generate a QR code here */}
                                        <div className="w-full h-full bg-gray-100 rounded flex items-center justify-center">
                                            <QrCodeIcon className="h-16 w-16 text-gray-400" />
                                        </div>
                                    </div>
                                </div>
                                <p className="text-sm text-gray-500 text-center mt-4">
                                    Scan to save this contact
                                </p>
                            </div>
                        )}

                        {/* Quick Actions */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div className="space-y-3">
                                <button
                                    onClick={downloadVCard}
                                    className="w-full btn-secondary"
                                >
                                    Download vCard
                                </button>
                                <button
                                    onClick={() => handleShare('copy')}
                                    className="w-full btn-secondary"
                                >
                                    Copy Contact Info
                                </button>
                            </div>
                        </div>

                        {/* Card Stats */}
                        <div className="card">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">Card Statistics</h3>
                            <div className="space-y-3">
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Views</span>
                                    <span className="font-semibold">{currentCard.views || 0}</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Shares</span>
                                    <span className="font-semibold">{currentCard.shares || 0}</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Downloads</span>
                                    <span className="font-semibold">{currentCard.downloads || 0}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CardPreview;