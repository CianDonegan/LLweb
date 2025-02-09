import React from 'react';
import styles from '../styles/About.module.css';

const About = () => {
  const achievements = [
    {
      number: '5+',
      title: 'Years Experience',
      description: 'Dedicated to nail artistry'
    },
    {
      number: '1000+',
      title: 'Happy Clients',
      description: 'Satisfied customers served'
    },
    {
      number: '50+',
      title: 'Nail Designs',
      description: 'Unique styles mastered'
    }
  ];

  const qualifications = [
    {
      year: '2023',
      title: 'Advanced Nail Art Certification',
      institution: 'International Nail Academy'
    },
    {
      year: '2022',
      title: 'Gel Extension Specialist',
      institution: 'Professional Beauty Institute'
    },
    {
      year: '2021',
      title: 'Nail Technology Diploma',
      institution: 'Dublin Beauty Academy'
    }
  ];

  return (
    <div className={styles.aboutPage}>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <h1>About Me</h1>
          <p className={styles.subtitle}>
            Passionate about creating beautiful nails and exceptional experiences
          </p>
        </div>
      </section>

      <section className={styles.story}>
        <div className={styles.container}>
          <div className={styles.storyContent}>
            <div className={styles.textContent}>
              <h2>My Journey</h2>
              <p>
                Welcome to LaylaLawlor Beauty! I'm Layla, a professional nail technician with over 5 years
                of experience in creating stunning nail designs. My passion for nail artistry began
                when I realized how a beautiful set of nails could boost someone's confidence and
                brighten their day.
              </p>
              <p>
                I specialize in gel extensions, artistic designs, and creating personalized experiences
                for each of my clients. My goal is to not just meet but exceed your expectations,
                ensuring you leave my studio feeling confident and beautiful.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section className={styles.achievements}>
        <div className={styles.container}>
          <div className={styles.achievementsGrid}>
            {achievements.map((achievement, index) => (
              <div key={index} className={styles.achievementCard}>
                <div className={styles.number}>{achievement.number}</div>
                <h3>{achievement.title}</h3>
                <p>{achievement.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.qualifications}>
        <div className={styles.container}>
          <h2>Professional Journey</h2>
          <div className={styles.timeline}>
            {qualifications.map((qual, index) => (
              <div key={index} className={styles.timelineItem}>
                <div className={styles.timelineContent}>
                  <span className={styles.year}>{qual.year}</span>
                  <h3>{qual.title}</h3>
                  <p>{qual.institution}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.values}>
        <div className={styles.container}>
          <h2>My Values</h2>
          <div className={styles.valuesGrid}>
            <div className={styles.valueCard}>
              <h3>Quality</h3>
              <p>Using only premium products and techniques for lasting results</p>
            </div>
            <div className={styles.valueCard}>
              <h3>Hygiene</h3>
              <p>Maintaining the highest standards of cleanliness and sterilization</p>
            </div>
            <div className={styles.valueCard}>
              <h3>Creativity</h3>
              <p>Bringing your vision to life with artistic flair and attention to detail</p>
            </div>
          </div>
        </div>
      </section>

      <section className={styles.cta}>
        <div className={styles.container}>
          <h2>Ready to Experience Professional Nail Care?</h2>
          <p>Book your appointment today and let's create something beautiful together</p>
          <button className={styles.ctaButton}>Book Now</button>
        </div>
      </section>
    </div>
  );
};

export default About; 