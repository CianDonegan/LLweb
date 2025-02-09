import React from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/Services.module.css';

const Services = () => {
  const services = [
    {
      title: 'Gel Polish',
      price: '€30',
      description: 'inc. detailed cuticle work, natural nail manicure, gel polish application, cuticle oil.',
      icon: '💅'
    },
    {
      title: 'Builder Gel/biab',
      price: '€35',
      description: 'inc. detailed cuticle work, natural nail manicure, builder gel application, file and shape, cuticle oil.',
      icon: '✨'
    },
    {
      title: 'Acrylic Extensions',
      price: '€40',
      description: 'inc. detailed cuticle work, natural nail manicure, acrylic application, file and shape, cuticle oil.',
      icon: '💎'
    },
    {
      title: 'Gel Polish on Toes',
      price: '€25',
      description: 'inc. foot soak, detailed cuticle work, natural nail manicure, gel polish application, cuticle oil.',
      icon: '👣'
    },
    {
      title: 'Full Pedicure',
      price: '€40',
      description: 'inc. foot soak, detailed cuticle work, hard skin removal, natural nail manicure, gel polish application, foot massage.',
      icon: '🦶'
    },
    {
      title: 'Deluxe Pedicure',
      price: '€45',
      description: 'inc. foot soak, detailed cuticle work, callus removal treatment, natural nail manicure, gel polish application, foot massage.',
      icon: '✨'
    }
  ];

  const additionalServices = [
    {
      title: 'Detailed Nail Art',
      price: '+€5',
      icon: '🎨'
    },
    {
      title: 'French',
      price: '+€5',
      icon: '🤍'
    },
    {
      title: 'Removal',
      price: '+€10',
      icon: '🧴'
    }
  ];

  return (
    <div className={styles.services}>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <h1 className={styles.title}>Our Services</h1>
          <p className={styles.subtitle}>
            Professional Nail Care Services by Layla Lawlor Beauty
          </p>
        </div>
      </section>

      <section className={styles.serviceCards}>
        <div className={styles.container}>
          <div className={styles.cardsGrid}>
            {services.map((service, index) => (
              <div key={index} className={styles.card}>
                <div className={styles.cardIcon}>{service.icon}</div>
                <h3>{service.title}</h3>
                <div className={styles.price}>{service.price}</div>
                <p>{service.description}</p>
                <Link to="/contact">
                  <button className={styles.bookButton}>Book Now</button>
                </Link>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.additionalServices}>
        <div className={styles.container}>
          <h2>Additional Services</h2>
          <div className={styles.addonsGrid}>
            {additionalServices.map((service, index) => (
              <div key={index} className={styles.addonCard}>
                <div className={styles.addonIcon}>{service.icon}</div>
                <h3>{service.title}</h3>
                <div className={styles.addonPrice}>{service.price}</div>
              </div>
            ))}
          </div>
          <div className={styles.note}>
            <p>* Refills are the same price as a full set for BIAB or Acrylic</p>
          </div>
        </div>
      </section>

      <section className={styles.cta}>
        <div className={styles.container}>
          <h2>Ready to book your appointment?</h2>
          <p>Experience professional nail care services</p>
          <Link to="/contact">
            <button className={styles.ctaButton}>Book Now</button>
          </Link>
        </div>
      </section>
    </div>
  );
};

export default Services; 