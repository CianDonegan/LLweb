import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/Booking.module.css';

const BookingConfirmation = () => {
  const [booking, setBooking] = useState(null);

  useEffect(() => {
    const savedBooking = localStorage.getItem('lastBooking');
    if (savedBooking) {
      setBooking(JSON.parse(savedBooking));
    }
  }, []);

  if (!booking) {
    return (
      <div className={styles.bookingPage}>
        <div className={styles.container}>
          <div className={styles.formSection}>
            <h2>Booking Not Found</h2>
            <p>No booking information available.</p>
            <Link to="/booking" className={styles.homeButton}>
              Make a New Booking
            </Link>
          </div>
        </div>
      </div>
    );
  }

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
              <h3>Booking Details</h3>
              <p><strong>Name:</strong> {booking.customer.full_name}</p>
              <p><strong>Date:</strong> {booking.date}</p>
              <p><strong>Time:</strong> {booking.booking_date.split('T')[1].substring(0, 5)}</p>
              <p><strong>Email:</strong> {booking.customer.email}</p>
              <p><strong>Phone:</strong> {booking.customer.phone}</p>
            </div>

            <div className={styles.confirmationMessage}>
              <p>Thank you for your booking! A confirmation email has been sent to your email address.</p>
              <p>If you need to make any changes to your booking, please contact us.</p>
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