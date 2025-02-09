import React from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/Home.module.css';

const Home = () => {
  const features = [
    {
      title: 'Professional Service',
      description: 'Expert nail care with attention to detail and hygiene.',
      icon: '💅'
    },
    {
      title: 'Quality Products',
      description: 'Using only the best professional nail care products.',
      icon: '✨'
    },
    {
      title: 'Beautiful Results',
      description: 'Stunning nails that make you feel confident.',
      icon: '💖'
    }
  ];

  return (
    <div>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <div className={styles.heroText}>
            <h1 className={styles.title}>
              Beautiful Nails,<br />
              Confident You
            </h1>
            <p className={styles.subtitle}>
              Professional nail care services in Dublin. Experience luxury treatments
              that leave you feeling beautiful and confident.
            </p>
            <div className={styles.ctaButtons}>
              <Link to="/contact">
                <button className={styles.primaryButton}>Book Now</button>
              </Link>
              <Link to="/services">
                <button className={styles.secondaryButton}>View Services</button>
              </Link>
            </div>
          </div>
        </div>
      </section>

      <section className={styles.features}>
        <div className={styles.featureContainer}>
          <h2 className={styles.featureTitle}>
            Why Choose LaylaLawlor Beauty
          </h2>
          <div className={styles.featureGrid}>
            {features.map((feature, index) => (
              <div key={index} className={styles.featureCard}>
                <div className={styles.featureIcon}>{feature.icon}</div>
                <h3>{feature.title}</h3>
                <p>{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.cta}>
        <div className={styles.container}>
          <h2>Ready for Beautiful Nails?</h2>
          <p>Book your appointment today and experience the difference</p>
          <Link to="/contact">
            <button className={styles.ctaButton}>Book Appointment</button>
          </Link>
        </div>
      </section>
    </div>
  );
};

export default Home; 