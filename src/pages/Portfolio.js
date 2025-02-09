import React from 'react';
import styles from '../styles/Portfolio.module.css';

const Portfolio = () => {
  const portfolioItems = [
    {
      title: 'Gel Polish Art',
      category: 'Nail Art',
      image: '/images/portfolio/gel-polish.jpg',
      description: 'Custom gel polish designs with intricate details'
    },
    {
      title: 'French Tips',
      category: 'Classic',
      image: '/images/portfolio/french-tips.jpg',
      description: 'Elegant and timeless French manicure'
    },
    {
      title: 'Acrylic Extensions',
      category: 'Extensions',
      image: '/images/portfolio/acrylics.jpg',
      description: 'Beautiful and durable acrylic nail extensions'
    },
    // Add more portfolio items
  ];

  return (
    <div className={styles.portfolio}>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <h1 className={styles.title}>Our Work</h1>
          <p className={styles.subtitle}>
            Browse through our collection of beautiful nail designs
          </p>
        </div>
      </section>

      <section className={styles.gallerySection}>
        <div className={styles.container}>
          <div className={styles.galleryGrid}>
            {portfolioItems.map((item, index) => (
              <div key={index} className={styles.galleryItem}>
                <div className={styles.imageContainer}>
                  <img 
                    src={item.image} 
                    alt={item.title}
                    onError={(e) => {
                      e.target.src = '/images/placeholder-nail.jpg';
                    }}
                  />
                  <div className={styles.overlay}>
                    <h3>{item.title}</h3>
                    <span>{item.category}</span>
                    <p>{item.description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.cta}>
        <div className={styles.container}>
          <h2>Ready to get your nails done?</h2>
          <p>Book an appointment today and let us create something beautiful for you</p>
          <button className={styles.ctaButton}>Book Now</button>
        </div>
      </section>
    </div>
  );
};

export default Portfolio; 