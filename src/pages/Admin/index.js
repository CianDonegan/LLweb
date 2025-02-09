import React, { useState } from 'react';
import styles from '../../styles/Admin.module.css';
import BookingsList from './BookingsList';
import Calendar from './Calendar';
import Settings from './Settings';

const Admin = () => {
  const [activeTab, setActiveTab] = useState('bookings');

  return (
    <div className={styles.adminDashboard}>
      <nav className={styles.sidebar}>
        <h2>Admin Panel</h2>
        <ul>
          <li 
            className={activeTab === 'bookings' ? styles.active : ''}
            onClick={() => setActiveTab('bookings')}
          >
            📅 Bookings
          </li>
          <li 
            className={activeTab === 'calendar' ? styles.active : ''}
            onClick={() => setActiveTab('calendar')}
          >
            📊 Calendar View
          </li>
          <li 
            className={activeTab === 'settings' ? styles.active : ''}
            onClick={() => setActiveTab('settings')}
          >
            ⚙️ Settings
          </li>
        </ul>
      </nav>

      <main className={styles.content}>
        {activeTab === 'bookings' && <BookingsList />}
        {activeTab === 'calendar' && <Calendar />}
        {activeTab === 'settings' && <Settings />}
      </main>
    </div>
  );
};

export default Admin; 