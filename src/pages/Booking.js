import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import styles from '../styles/Booking.module.css';
import DatePicker from 'react-datepicker';
import "react-datepicker/dist/react-datepicker.css";

const Booking = () => {
  const navigate = useNavigate();
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [error, setError] = useState('');
  const [bookingData, setBookingData] = useState({
    service: '',
    date: new Date(),
    time: '',
    name: '',
    email: '',
    phone: ''
  });

  const services = [
    { id: 'gel-polish', name: 'Gel Polish', price: '€30' },
    { id: 'builder-gel', name: 'Builder Gel', price: '€35' },
    { id: 'acrylic-extensions', name: 'Acrylic Extensions', price: '€40' },
    { id: 'gel-toes', name: 'Gel Polish on Toes', price: '€25' },
    { id: 'full-pedicure', name: 'Full Pedicure', price: '€40' },
    { id: 'deluxe-pedicure', name: 'Deluxe Pedicure', price: '€45' }
  ];

  const availableTimes = [
    '09:00', '10:00', '11:00', '12:00',
    '13:00', '14:00', '15:00', '16:00', '17:00'
  ];

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmitting(true);
    setError('');

    try {
      const response = await fetch('http://localhost:5000/api/bookings', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          service: bookingData.service,
          date: bookingData.date.toISOString().split('T')[0],
          time: bookingData.time,
          name: bookingData.name,
          email: bookingData.email,
          phone: bookingData.phone
        }),
      });

      if (!response.ok) {
        throw new Error('Booking failed');
      }

      const data = await response.json();
      localStorage.setItem('lastBooking', JSON.stringify({
        ...bookingData,
        date: bookingData.date.toLocaleDateString(),
        confirmationNumber: data.confirmation_number
      }));

      navigate('/booking/confirmation');
    } catch (error) {
      setError('Failed to submit booking. Please try again.');
      console.error('Booking error:', error);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className={styles.bookingPage}>
      <div className={styles.container}>
        <div className={styles.formSection}>
          <h2>Book Your Appointment</h2>
          {error && (
            <div className={styles.error}>
              {error}
            </div>
          )}
          <form onSubmit={handleSubmit} className={styles.bookingForm}>
            <div className={styles.formGroup}>
              <label>Select Service</label>
              <select
                value={bookingData.service}
                onChange={(e) => setBookingData({...bookingData, service: e.target.value})}
                required
              >
                <option value="">Choose a service...</option>
                {services.map((service) => (
                  <option key={service.id} value={service.id}>
                    {service.name} - {service.price}
                  </option>
                ))}
              </select>
            </div>

            <div className={styles.formGroup}>
              <label>Select Date</label>
              <DatePicker
                selected={bookingData.date}
                onChange={(date) => setBookingData({...bookingData, date})}
                dateFormat="MMMM d, yyyy"
                minDate={new Date()}
                filterDate={(date) => date.getDay() !== 0} // Exclude Sundays
                className={styles.datePicker}
                required
              />
            </div>

            <div className={styles.formGroup}>
              <label>Select Time</label>
              <select
                value={bookingData.time}
                onChange={(e) => setBookingData({...bookingData, time: e.target.value})}
                required
              >
                <option value="">Choose a time...</option>
                {availableTimes.map((time) => (
                  <option key={time} value={time}>{time}</option>
                ))}
              </select>
            </div>

            <div className={styles.formGroup}>
              <label>Your Name</label>
              <input
                type="text"
                value={bookingData.name}
                onChange={(e) => setBookingData({...bookingData, name: e.target.value})}
                required
              />
            </div>

            <div className={styles.formGroup}>
              <label>Email</label>
              <input
                type="email"
                value={bookingData.email}
                onChange={(e) => setBookingData({...bookingData, email: e.target.value})}
                required
              />
            </div>

            <div className={styles.formGroup}>
              <label>Phone</label>
              <input
                type="tel"
                value={bookingData.phone}
                onChange={(e) => setBookingData({...bookingData, phone: e.target.value})}
                required
              />
            </div>

            <button 
              type="submit" 
              className={styles.submitButton}
              disabled={isSubmitting}
            >
              {isSubmitting ? 'Submitting...' : 'Book Appointment'}
            </button>
          </form>

          <div className={styles.infoCard}>
            <div className={styles.infoItem}>
              <h3>Opening Hours</h3>
              <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
              <p>Saturday: 10:00 AM - 4:00 PM</p>
              <p>Sunday: Closed</p>
            </div>
            <div className={styles.infoItem}>
              <h3>Location</h3>
              <p>Dublin, Ireland</p>
            </div>
            <div className={styles.infoItem}>
              <h3>Contact</h3>
              <p>Email: layla@beauty.com</p>
              <p>Instagram: @laylalawlorbeauty</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Booking; 