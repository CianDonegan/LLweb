import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/Home.module.css';
import nailsBg from '../assets/images/nails001.png';

const Home = () => {
  const features = [
    {
      title: 'Hygiene First',
      description: 'Medical-grade sterilization & single-use tools',
      icon: '🧼'
    },
    {
      title: 'Eco-Friendly',
      description: 'Vegan & cruelty-free products',
      icon: '🌿'
    },
    {
      title: 'Expert Artists',
      description: '5+ years experience average',
      icon: '👩🎨'
    },
    {
      title: 'Flexible Hours',
      description: 'Evening & weekend appointments',
      icon: '⏰'
    }
  ];

  useEffect(() => {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '50px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add(styles.visible);
        }
      });
    }, observerOptions);

    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
      section.classList.add(styles.fadeIn);
      observer.observe(section);
    });

    return () => observer.disconnect();
  }, []);

  return (
    <div>
      <section 
        className={styles.hero}
        style={{
          background: `linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)),
            url(${nailsBg})`,
          backgroundPosition: 'center',
          backgroundSize: '150%',
          backgroundRepeat: 'no-repeat'
        }}
      >
        <div className={styles.heroContent}>
          <div className={styles.heroText}>
            <h1 className={styles.title}>
              Premium Nail Artistry<br />
              <span className={styles.titleHighlight}>Crafted with Care</span>
            </h1>
            <p className={styles.subtitle}>
              Dublin Nail Studio | Organic Products | Luxury Experience
            </p>
            <div className={styles.ctaButtons}>
              <Link to="/booking">
                <button className={styles.primaryButton}>                                                               
                  Book Consultation ➔
                </button>
              </Link>
              <Link to="/portfolio">
                <button className={styles.secondaryButton}>
                  View Gallery ✨
                </button>
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
                <p className={styles.featureDescription}>{feature.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.ctaSection}>
        <div className={styles.ctaContainer}>
          <h2>Your Nail Journey Starts Here</h2>
          <p className={styles.ctaText}>
            Limited Availability - Book Your Slot Now
          </p>
          <div className={styles.ctaButtons}>
            <Link to="/booking">
              <button className={styles.ctaButton}>
                📅 Book Appointment
              </button>
            </Link>
            <a href="tel:+3531234567" className={styles.phoneLink}>
              📞 Call Now: +353 123 4567
            </a>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Home; 