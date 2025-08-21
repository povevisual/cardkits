import React from 'react';
import { useAuth } from './contexts/AuthContext';
import Navigation from './components/Layout/Navigation';
import Footer from './components/Layout/Footer';

const App = ({ children }) => {
    const { user } = useAuth();

    return (
        <div className="min-h-screen bg-gray-50">
            <Navigation />
            <main className="flex-1">
                {children}
            </main>
            <Footer />
        </div>
    );
};

export default App;