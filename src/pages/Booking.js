import React, { useState, useEffect } from 'react';
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
  const [services, setServices] = useState([]);
  const [availableTimes, setAvailableTimes] = useState([]);
  const [validationErrors, setValidationErrors] = useState({});

  useEffect(() => {
    const fetchServices = async () => {
      try {
        console.log('Fetching services...');
        const response = await fetch('/api/services');
        
        if (!response.ok) {
          const errorText = await response.text();
          console.error('Response not OK:', response.status, errorText);
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Services data received:', data);
        
        if (!Array.isArray(data)) {
          console.error('Invalid data format received:', data);
          throw new Error('Invalid data format received');
        }

        if (data.length === 0) {
          console.log('No services available');
          setError('No services available at this time');
          setServices([]);
          return;
        }
        
        setServices(data);
        setError('');
      } catch (error) {
        console.error('Error fetching services:', error);
        setError(`Failed to load services: ${error.message}`);
        setServices([]);
      }
    };

    fetchServices();
  }, []);

  const fetchAvailableTimes = async (selectedDate) => {
    if (!bookingData.service) {
      console.log('No service selected, skipping time fetch');
      setAvailableTimes([]);
      return;
    }

    try {
      const dateStr = selectedDate.toISOString().split('T')[0];
      console.log('Fetching times for date:', dateStr);
      
      const response = await fetch(`/api/availability?date=${dateStr}`);
      if (!response.ok) {
        const errorData = await response.text();
        console.error('Error response:', errorData);
        throw new Error(`Failed to fetch times: ${response.status}`);
      }
      
      const times = await response.json();
      console.log('Received available times:', times);
      
      if (!Array.isArray(times)) {
        console.error('Invalid times data:', times);
        throw new Error('Invalid time data received');
      }
      
      setAvailableTimes(times);
      setError('');
    } catch (error) {
      console.error('Error fetching times:', error);
      setError('Failed to load available times');
      setAvailableTimes([]);
    }
  };

  const handleDateChange = (date) => {
    setBookingData(prev => ({ ...prev, date, time: '' }));
    if (bookingData.service) {
      fetchAvailableTimes(date);
    }
  };

  useEffect(() => {
    if (bookingData.service) {
      fetchAvailableTimes(bookingData.date);
    }
  }, [bookingData.service, bookingData.date]);

  const validateForm = () => {
    const errors = {};
    
    // Service validation
    if (!bookingData.service) {
      errors.service = 'Please select a service';
    }

    // Date validation
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const selectedDate = new Date(bookingData.date);
    selectedDate.setHours(0, 0, 0, 0);

    if (!bookingData.date) {
      errors.date = 'Please select a date';
    } else if (selectedDate < today) {
      errors.date = 'Please select a future date';
    } else if (selectedDate.getDay() === 0) { // Sunday
      errors.date = 'We are closed on Sundays';
    }

    // Time validation
    if (!bookingData.time) {
      errors.time = 'Please select a time';
    }

    // Name validation
    if (!bookingData.name) {
      errors.name = 'Name is required';
    } else if (bookingData.name.length < 2) {
      errors.name = 'Name must be at least 2 characters long';
    } else if (!/^[a-zA-Z\s'-]+$/.test(bookingData.name)) {
      errors.name = 'Name contains invalid characters';
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!bookingData.email) {
      errors.email = 'Email is required';
    } else if (!emailRegex.test(bookingData.email)) {
      errors.email = 'Please enter a valid email address';
    }

    // Phone validation for Irish numbers
    const phoneRegex = /^(\+353|0)[1-9]\d{8}$/;
    if (!bookingData.phone) {
      errors.phone = 'Phone number is required';
    } else if (!phoneRegex.test(bookingData.phone.replace(/\s+/g, ''))) {
      errors.phone = 'Please enter a valid Irish phone number (e.g., 087xxxxxxx or +353xxxxxxxxx)';
    }

    setValidationErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!validateForm()) {
      setError('Please correct the errors in the form');
      return;
    }

    setIsSubmitting(true);
    setError('');

    try {
      // Format the date and time properly
      const bookingDateTime = new Date(
        `${bookingData.date.toISOString().split('T')[0]}T${bookingData.time}:00`
      );

      const submitData = {
        customer: {
          email: bookingData.email,
          full_name: bookingData.name,
          phone: bookingData.phone
        },
        service: {
          id: bookingData.service
        },
        booking_date: bookingDateTime.toISOString(),
        notes: ''
      };

      console.log('Sending booking data:', submitData);

      const response = await fetch('/api/bookings', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(submitData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        console.error('Booking response error:', errorData);
        throw new Error(errorData.details || 'Booking failed');
      }

      const data = await response.json();
      console.log('Booking successful:', data);
      
      localStorage.setItem('lastBooking', JSON.stringify({
        ...submitData,
        date: bookingData.date.toLocaleDateString(),
        confirmationNumber: data.id
      }));

      navigate('/booking/confirmation');
    } catch (error) {
      console.error('Booking error:', error);
      setError('Failed to submit booking: ' + error.message);
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
                onChange={(e) => {
                  setBookingData(prev => ({...prev, service: e.target.value}));
                  setValidationErrors(prev => ({...prev, service: ''}));
                }}
                className={validationErrors.service ? styles.errorInput : ''}
                required
              >
                <option value="">Choose a service...</option>
                {services && services.map((service) => (
                  <option key={service.id} value={service.id}>
                    {service.name} - €{Number(service.price).toFixed(2)}
                  </option>
                ))}
              </select>
              {validationErrors.service && (
                <div className={styles.errorMessage}>{validationErrors.service}</div>
              )}
            </div>

            <div className={styles.formGroup}>
              <label>Select Date</label>
              <DatePicker
                selected={bookingData.date}
                onChange={(date) => {
                  handleDateChange(date);
                  setValidationErrors(prev => ({...prev, date: ''}));
                }}
                dateFormat="MMMM d, yyyy"
                minDate={new Date()}
                filterDate={(date) => date.getDay() !== 0} // Exclude Sundays
                className={`${styles.datePicker} ${validationErrors.date ? styles.errorInput : ''}`}
                required
              />
              {validationErrors.date && (
                <div className={styles.errorMessage}>{validationErrors.date}</div>
              )}
            </div>

            <div className={styles.formGroup}>
              <label>Select Time</label>
              {!bookingData.service ? (
                <div className={styles.message}>Please select a service first</div>
              ) : availableTimes.length === 0 ? (
                <div className={styles.message}>
                  {error || 'No available times for selected date'}
                </div>
              ) : (
                <select
                  value={bookingData.time}
                  onChange={(e) => {
                    setBookingData(prev => ({...prev, time: e.target.value}));
                    setValidationErrors(prev => ({...prev, time: ''}));
                  }}
                  className={validationErrors.time ? styles.errorInput : ''}
                  required
                >
                  <option value="">Choose a time...</option>
                  {availableTimes.map((time) => (
                    <option key={time} value={time}>
                      {time}
                    </option>
                  ))}
                </select>
              )}
              {validationErrors.time && (
                <div className={styles.errorMessage}>{validationErrors.time}</div>
              )}
            </div>

            <div className={styles.formGroup}>
              <label>Your Name</label>
              <input
                type="text"
                value={bookingData.name}
                onChange={(e) => {
                  setBookingData(prev => ({...prev, name: e.target.value}));
                  setValidationErrors(prev => ({...prev, name: ''}));
                }}
                className={validationErrors.name ? styles.errorInput : ''}
                required
              />
              {validationErrors.name && (
                <div className={styles.errorMessage}>{validationErrors.name}</div>
              )}
            </div>

            <div className={styles.formGroup}>
              <label>Email</label>
              <input
                type="email"
                value={bookingData.email}
                onChange={(e) => {
                  setBookingData(prev => ({...prev, email: e.target.value}));
                  setValidationErrors(prev => ({...prev, email: ''}));
                }}
                className={validationErrors.email ? styles.errorInput : ''}
                required
              />
              {validationErrors.email && (
                <div className={styles.errorMessage}>{validationErrors.email}</div>
              )}
            </div>

            <div className={styles.formGroup}>
              <label>Phone</label>
              <input
                type="tel"
                value={bookingData.phone}
                onChange={(e) => {
                  setBookingData(prev => ({...prev, phone: e.target.value}));
                  setValidationErrors(prev => ({...prev, phone: ''}));
                }}
                className={validationErrors.phone ? styles.errorInput : ''}
                placeholder="087xxxxxxx or +353xxxxxxxxx"
                required
              />
              {!validationErrors.phone && (
                <div className={styles.helperText}>Enter Irish mobile or landline number</div>
              )}
              {validationErrors.phone && (
                <div className={styles.errorMessage}>{validationErrors.phone}</div>
              )}
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