import React, { useState } from 'react';
import styles from '../../styles/Booking.module.css';
import DatePicker from 'react-datepicker';
import "react-datepicker/dist/react-datepicker.css";

const Booking = () => {
  const [startDate, setStartDate] = useState(new Date());

  return (
    <div className={styles.bookingPage}>
      <div className={styles.container}>
        <div className={styles.formSection}>
          <h2>Book Your Appointment</h2>
          <div className={styles.formGroup}>
            <label>Select Date</label>
            <DatePicker
              selected={startDate}
              onChange={(date) => setStartDate(date)}
              className={styles.datePicker}
            />
          </div>
          <div className={styles.infoCard}>
            <div className={styles.infoItem}>
              <h3>Opening Hours</h3>
              <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
              <p>Saturday: 10:00 AM - 4:00 PM</p>
              <p>Sunday: Closed</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Booking; 