import React, { useState } from 'react';
import styles from '../styles/Portfolio.module.css';
import nails002 from '../assets/images/portfolio/nails002.png';
import nails003 from '../assets/images/portfolio/nails003.png';
import nails004 from '../assets/images/portfolio/nails004.png';
import nails005 from '../assets/images/portfolio/nails005.png';
import nails006 from '../assets/images/portfolio/nails006.png';
import nails007 from '../assets/images/portfolio/nails007.png';
import nails008 from '../assets/images/portfolio/nails008.png';
import nails009 from '../assets/images/portfolio/nails009.png';
import nails010 from '../assets/images/portfolio/nails010.png';
import nails021 from '../assets/images/portfolio/nails021.png';
import feet01 from '../assets/images/portfolio/feet01.png';

const Portfolio = () => {
  const [selectedImage, setSelectedImage] = useState(null);

  const openModal = (image) => {
    setSelectedImage(image);
    document.body.style.overflow = 'hidden';
  };

  const closeModal = () => {
    setSelectedImage(null);
    document.body.style.overflow = 'unset';
  };

  const portfolioImages = [
    { src: nails002, alt: 'Elegant Nail Design', description: 'Sophisticated nail art with detailed patterns' },
    { src: nails003, alt: 'Crystal Nail Art', description: 'Sparkling crystal embellished design' },
    { src: nails004, alt: 'French Manicure', description: 'Classic french tips with modern twist' },
    { src: nails005, alt: 'Glitter Design', description: 'Glamorous glitter nail design' },
    { src: nails006, alt: 'Artistic Pattern', description: 'Creative pattern work with precision' },
    { src: nails007, alt: 'Delicate Design', description: 'Delicate and intricate nail artistry' },
    { src: nails008, alt: 'Modern Style', description: 'Contemporary nail art design' },
    { src: nails009, alt: 'Elegant Pattern', description: 'Sophisticated pattern work' },
    { src: nails010, alt: 'Unique Design', description: 'Unique and creative nail art' },
    { src: nails021, alt: 'Special Design', description: 'Special occasion nail design' },
    { src: feet01, alt: 'Pedicure Design', description: 'Professional pedicure work' }
  ];

  return (
    <div className={styles.portfolioPage}>
      <div className={styles.header}>
        <h1>Our Work</h1>
        <p>Browse through our collection of nail designs and transformations</p>
      </div>
      
      <div className={styles.galleryGrid}>
        {portfolioImages.map((image, index) => (
          <div 
            key={index} 
            className={styles.galleryItem}
            onClick={() => openModal(image)}
          >
            <img src={image.src} alt={image.alt} />
            <div className={styles.imageOverlay}>
              <p>{image.description}</p>
            </div>
          </div>
        ))}
      </div>

      {/* Modal for full-screen view */}
      <div className={`${styles.modal} ${selectedImage ? styles.open : ''}`} onClick={closeModal}>
        <div className={styles.modalContent} onClick={e => e.stopPropagation()}>
          {selectedImage && (
            <>
              <img 
                src={selectedImage.src} 
                alt={selectedImage.alt} 
                className={styles.modalImage}
              />
              <button className={styles.closeButton} onClick={closeModal}>×</button>
            </>
          )}
        </div>
      </div>
    </div>
  );
};

export default Portfolio; 