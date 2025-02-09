import React, { useState } from 'react';
import styles from '../styles/Contact.module.css';

const Contact = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    service: '',
    message: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Form submitted:', formData);
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const services = [
    'Gel Polish',
    'Builder Gel/biab',
    'Acrylic Extensions',
    'Gel Polish on Toes',
    'Full Pedicure',
    'Deluxe Pedicure'
  ];

  const contactInfo = [
    {
      title: 'Location',
      info: 'Dublin, Ireland',
      icon: '📍'
    },
    {
      title: 'Email',
      info: 'layla@beauty.com',
      icon: '✉️'
    },
    {
      title: 'Instagram',
      info: '@laylalawlorbeauty',
      icon: '📱'
    }
  ];

  return (
    <div className={styles.contact}>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <h1 className={styles.title}>Book an Appointment</h1>
          <p className={styles.subtitle}>
            Get in touch to schedule your next beauty treatment
          </p>
        </div>
      </section>

      <section className={styles.contactSection}>
        <div className={styles.container}>
          <div className={styles.contactGrid}>
            <div className={styles.formContainer}>
              <h2>Send us a Message</h2>
              <form onSubmit={handleSubmit} className={styles.form}>
                <div className={styles.formGroup}>
                  <label htmlFor="name">Name</label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    value={formData.name}
                    onChange={handleChange}
                    required
                  />
                </div>
                <div className={styles.formGroup}>
                  <label htmlFor="email">Email</label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    required
                  />
                </div>
                <div className={styles.formGroup}>
                  <label htmlFor="phone">Phone</label>
                  <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value={formData.phone}
                    onChange={handleChange}
                    required
                  />
                </div>
                <div className={styles.formGroup}>
                  <label htmlFor="service">Service</label>
                  <select
                    id="service"
                    name="service"
                    value={formData.service}
                    onChange={handleChange}
                    required
                  >
                    <option value="">Select a service</option>
                    {services.map((service, index) => (
                      <option key={index} value={service}>
                        {service}
                      </option>
                    ))}
                  </select>
                </div>
                <div className={styles.formGroup}>
                  <label htmlFor="message">Message</label>
                  <textarea
                    id="message"
                    name="message"
                    value={formData.message}
                    onChange={handleChange}
                    rows="4"
                    required
                  />
                </div>
                <button type="submit" className={styles.submitButton}>
                  Send Message
                </button>
              </form>
            </div>

            <div className={styles.contactInfo}>
              <h2>Contact Information</h2>
              <div className={styles.infoGrid}>
                {contactInfo.map((item, index) => (
                  <div key={index} className={styles.infoCard}>
                    <div className={styles.infoIcon}>{item.icon}</div>
                    <h3>{item.title}</h3>
                    <p>{item.info}</p>
                  </div>
                ))}
              </div>
              <div className={styles.hours}>
                <h3>Opening Hours</h3>
                <ul>
                  <li>Monday - Friday: 9:00 AM - 6:00 PM</li>
                  <li>Saturday: 10:00 AM - 4:00 PM</li>
                  <li>Sunday: Closed</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className={styles.mapSection}>
        <div className={styles.container}>
          <h2>Our Location</h2>
          <div className={styles.mapPlaceholder}>
            {/* Replace with actual map integration */}
            <div className={styles.map}>
              Map will be displayed here
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Contact; 