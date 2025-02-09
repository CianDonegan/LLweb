import React from 'react';
import styles from '../styles/Services.module.css';

const Services = () => {
  const services = [
    {
      icon: '💅',
      name: 'Gel Polish',
      price: '€30',
      description: 'inc. detailed cuticle work, natural nail manicure, gel polish application, cuticle oil'
    },
    {
      icon: '✨',
      name: 'Builder Gel hiab',
      price: '€35',
      description: 'inc. detailed cuticle work, natural nail manicure, builder gel application, file and shape, cuticle oil'
    },
    {
      icon: '💎',
      name: 'Acrylic Extensions',
      price: '€40',
      description: 'inc. detailed cuticle work, natural nail manicure, acrylic application, file and shape, cuticle oil'
    },
    {
      icon: '👣',
      name: 'Gel Polish on Toes',
      price: '€25',
      description: 'inc. foot soak, detailed cuticle work, natural nail manicure, gel polish application, cuticle oil'
    },
    {
      icon: '🦶',
      name: 'Full Pedicure',
      price: '€40',
      description: 'inc. foot soak, detailed cuticle work, hard skin removal, natural nail manicure, gel polish application, foot massage'
    },
    {
      icon: '✨',
      name: 'Deluxe Pedicure',
      price: '€45',
      description: 'inc. foot soak, detailed cuticle work, callus removal treatment, natural nail manicure, gel polish application, foot massage'
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
    <div className={styles.servicesPage}>
      <div className={styles.header}>
        <h1>My Services</h1>
        <p>Professional Nail Care Services by Layla Lawlor Beauty</p>
      </div>
      
      <div className={styles.servicesGrid}>
        {services.map((service, index) => (
          <div key={index} className={styles.serviceCard}>
            <div className={styles.serviceIcon}>{service.icon}</div>
            <h2>{service.name}</h2>
            <div className={styles.price}>{service.price}</div>
            <p className={styles.description}>{service.description}</p>
            <button className={styles.bookButton}>Book Now</button>
          </div>
        ))}
      </div>

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
          <button className={styles.ctaButton}>Book Now</button>
        </div>
      </section>
    </div>
  );
};

export default Services; 