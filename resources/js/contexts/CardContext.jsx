import React, { createContext, useContext, useState, useEffect } from 'react';
import axios from 'axios';

const CardContext = createContext();

export const useCard = () => {
    const context = useContext(CardContext);
    if (!context) {
        throw new Error('useCard must be used within a CardProvider');
    }
    return context;
};

export const CardProvider = ({ children }) => {
    const [cards, setCards] = useState([]);
    const [currentCard, setCurrentCard] = useState(null);
    const [loading, setLoading] = useState(false);

    const fetchCards = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/api/cards');
            setCards(response.data);
        } catch (error) {
            console.error('Error fetching cards:', error);
        } finally {
            setLoading(false);
        }
    };

    const createCard = async (cardData) => {
        try {
            setLoading(true);
            const response = await axios.post('/api/cards', cardData);
            const newCard = response.data;
            setCards(prev => [...prev, newCard]);
            setCurrentCard(newCard);
            return { success: true, card: newCard };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.message || 'Failed to create card' 
            };
        } finally {
            setLoading(false);
        }
    };

    const updateCard = async (id, cardData) => {
        try {
            setLoading(true);
            const response = await axios.put(`/api/cards/${id}`, cardData);
            const updatedCard = response.data;
            setCards(prev => prev.map(card => 
                card.id === id ? updatedCard : card
            ));
            setCurrentCard(updatedCard);
            return { success: true, card: updatedCard };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.message || 'Failed to update card' 
            };
        } finally {
            setLoading(false);
        }
    };

    const deleteCard = async (id) => {
        try {
            setLoading(true);
            await axios.delete(`/api/cards/${id}`);
            setCards(prev => prev.filter(card => card.id !== id));
            if (currentCard?.id === id) {
                setCurrentCard(null);
            }
            return { success: true };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.message || 'Failed to delete card' 
            };
        } finally {
            setLoading(false);
        }
    };

    const getCard = async (id) => {
        try {
            setLoading(true);
            const response = await axios.get(`/api/cards/${id}`);
            const card = response.data;
            setCurrentCard(card);
            return { success: true, card };
        } catch (error) {
            return { 
                success: false, 
                error: error.response?.data?.message || 'Failed to fetch card' 
            };
        } finally {
            setLoading(false);
        }
    };

    const value = {
        cards,
        currentCard,
        loading,
        fetchCards,
        createCard,
        updateCard,
        deleteCard,
        getCard,
        setCurrentCard
    };

    return (
        <CardContext.Provider value={value}>
            {children}
        </CardContext.Provider>
    );
};