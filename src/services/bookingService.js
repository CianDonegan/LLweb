import axios from 'axios';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:5000/api';

export const bookingService = {
  // Check availability for a given date and service
  checkAvailability: async (date, service) => {
    try {
      const response = await axios.get(`${API_URL}/availability`, {
        params: { date, service }
      });
      return response.data.availableSlots;
    } catch (error) {
      throw new Error('Failed to fetch availability');
    }
  },

  // Create a new booking
  createBooking: async (bookingData) => {
    try {
      const response = await axios.post(`${API_URL}/bookings`, bookingData);
      return response.data;
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to create booking');
    }
  },

  // Initialize payment
  initializePayment: async (bookingId, amount) => {
    try {
      const response = await axios.post(`${API_URL}/payments/initialize`, {
        bookingId,
        amount
      });
      return response.data.clientSecret;
    } catch (error) {
      throw new Error('Failed to initialize payment');
    }
  }
}; 