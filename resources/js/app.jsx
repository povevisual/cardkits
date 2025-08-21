import React from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import App from './App';
import './bootstrap';

// Import components
import Dashboard from './components/Dashboard';
import CardBuilder from './components/CardBuilder';
import CardPreview from './components/CardPreview';
import Login from './components/Auth/Login';
import Register from './components/Auth/Register';
import Profile from './components/Profile';
import Settings from './components/Settings';

// Import context providers
import { AuthProvider } from './contexts/AuthContext';
import { CardProvider } from './contexts/CardContext';

const container = document.getElementById('app');
const root = createRoot(container);

root.render(
    <React.StrictMode>
        <AuthProvider>
            <CardProvider>
                <Router>
                    <App>
                        <Routes>
                            <Route path="/" element={<Dashboard />} />
                            <Route path="/login" element={<Login />} />
                            <Route path="/register" element={<Register />} />
                            <Route path="/builder" element={<CardBuilder />} />
                            <Route path="/preview/:id" element={<CardPreview />} />
                            <Route path="/profile" element={<Profile />} />
                            <Route path="/settings" element={<Settings />} />
                        </Routes>
                    </App>
                </Router>
            </CardProvider>
        </AuthProvider>
    </React.StrictMode>
);