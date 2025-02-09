import React, { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import styles from '../styles/Booking.module.css';

const BookingConfirmation = () => {
  const [booking, setBooking] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const bookingData = localStorage.getItem('lastBooking');
    if (!bookingData) {
      navigate('/booking');
      return;
    }
    setBooking(JSON.parse(bookingData));
  }, [navigate]);

  if (!booking) return null;

  return (
    <div className={styles.bookingPage}>
      <div className={styles.container}>
        <div className={styles.formSection}>
          <h2>Booking Confirmed!</h2>
          <div className={styles.confirmationCard}>
            <div className={styles.confirmationNumber}>
              Confirmation Number: {booking.confirmationNumber}
            </div>
            <div className={styles.bookingDetails}>
              <h3>Appointment Details</h3>
              <p><strong>Service:</strong> {booking.service}</p>
              <p><strong>Date:</strong> {booking.date}</p>
              <p><strong>Time:</strong> {booking.time}</p>
              <p><strong>Name:</strong> {booking.name}</p>
              <p><strong>Email:</strong> {booking.email}</p>
              <p><strong>Phone:</strong> {booking.phone}</p>
            </div>
            <div className={styles.confirmationMessage}>
              <p>Thank you for booking with us! We have sent a confirmation email to {booking.email}.</p>
              <p>Please arrive 5-10 minutes before your appointment time.</p>
            </div>
            <div className={styles.confirmationActions}>
              <Link to="/" className={styles.homeButton}>
                Return to Home
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default BookingConfirmation; 