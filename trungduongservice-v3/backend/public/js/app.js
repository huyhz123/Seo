// API Configuration
const API_URL = window.location.origin + '/api';

// Helper Functions
const getToken = () => localStorage.getItem('token');
const getUser = () => JSON.parse(localStorage.getItem('user') || '{}');
const setToken = (token) => localStorage.setItem('token', token);
const setUser = (user) => localStorage.setItem('user', JSON.stringify(user));
const clearAuth = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
};

// Check if user is logged in
const checkAuth = () => {
    const token = getToken();
    if (!token) {
        window.location.href = '/login.html';
        return false;
    }
    return true;
};

// API Request Helper
const apiRequest = async (endpoint, options = {}) => {
    const token = getToken();
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers,
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    try {
        const response = await fetch(`${API_URL}${endpoint}`, {
            ...options,
            headers,
        });

        const data = await response.json();

        if (response.status === 401) {
            clearAuth();
            window.location.href = '/login.html';
            return null;
        }

        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
};

// API Request Helper for FormData (file uploads)
const apiRequestFormData = async (endpoint, formData) => {
    const token = getToken();
    const headers = {
        'Accept': 'application/json',
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    try {
        const response = await fetch(`${API_URL}${endpoint}`, {
            method: 'POST',
            headers,
            body: formData,
        });

        const data = await response.json();

        if (response.status === 401) {
            clearAuth();
            window.location.href = '/login.html';
            return null;
        }

        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong');
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
};

// Show Alert
const showAlert = (message, type = 'success') => {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        setTimeout(() => alertDiv.remove(), 5000);
    }
};

// Format Currency
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    }).format(amount);
};

// Format Date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN');
};

// Update Navbar User Info
const updateNavbarUser = () => {
    const user = getUser();
    const userNameElement = document.getElementById('userName');
    if (userNameElement && user.name) {
        userNameElement.textContent = user.name;
    }
};

// Logout
const logout = async () => {
    try {
        await apiRequest('/logout', { method: 'POST' });
    } catch (error) {
        console.error('Logout error:', error);
    } finally {
        clearAuth();
        window.location.href = '/login.html';
    }
};

// Modal Helper
const openModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
    }
};

const closeModal = (modalId) => {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
    }
};

// Initialize page
document.addEventListener('DOMContentLoaded', () => {
    // Check authentication for protected pages
    if (!window.location.pathname.includes('login.html')) {
        checkAuth();
        updateNavbarUser();
    }

    // Setup logout button
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', logout);
    }
});
