import React from 'react';
import { Link } from 'react-router-dom';
import styles from '../styles/About.module.css';

const About = () => {
  const teamMembers = [
    {
      name: 'John Doe',
      role: 'CEO & Founder',
      image: 'https://i.pravatar.cc/200?img=1',
      bio: 'Visionary leader with 15+ years of experience.',
    },
    {
      name: 'Jane Smith',
      role: 'CTO',
      image: 'https://i.pravatar.cc/200?img=2',
      bio: 'Tech innovator and software architect.',
    },
    {
      name: 'Mike Johnson',
      role: 'Head of Design',
      image: 'https://i.pravatar.cc/200?img=3',
      bio: 'Award-winning designer and UX expert.',
    },
  ];

  const values = [
    {
      title: 'Quality',
      description: 'Using premium products and techniques for the best results.',
      icon: '✨'
    },
    {
      title: 'Hygiene',
      description: 'Maintaining the highest standards of cleanliness and safety.',
      icon: '🧼'
    },
    {
      title: 'Service',
      description: 'Providing a luxurious and comfortable experience.',
      icon: '👑'
    }
  ];

  return (
    <div className={styles.about}>
      <section className={styles.hero}>
        <div className={styles.heroContent}>
          <h1 className={styles.title}>About LaylaLawlor Beauty</h1>
          <p className={styles.subtitle}>
            Creating beautiful nails and confident smiles since 2020
          </p>
        </div>
      </section>

      <section className={styles.story}>
        <div className={styles.container}>
          <div className={styles.storyContent}>
            <h2>Our Story</h2>
            <p>
              LaylaLawlor Beauty was founded with a passion for nail artistry and a
              commitment to excellence. With years of experience and dedication to
              the craft, we've built a reputation for providing exceptional nail
              care services in Dublin.
            </p>
            <p>
              Our mission is to enhance your natural beauty and boost your
              confidence through professional nail care services. We believe in
              creating a relaxing environment where you can unwind while receiving
              top-quality treatments.
            </p>
          </div>
        </div>
      </section>

      <section className={styles.values}>
        <div className={styles.container}>
          <h2>Our Values</h2>
          <div className={styles.valuesGrid}>
            {values.map((value, index) => (
              <div key={index} className={styles.valueCard}>
                <div className={styles.valueIcon}>{value.icon}</div>
                <h3>{value.title}</h3>
                <p>{value.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className={styles.cta}>
        <div className={styles.container}>
          <h2>Experience the Difference</h2>
          <p>Join our growing family of satisfied clients</p>
          <Link to="/contact">
            <button className={styles.ctaButton}>Book Now</button>
          </Link>
        </div>
      </section>

      <section className={styles.team}>
        <div className={styles.container}>
          <h2>Meet Our Team</h2>
          <div className={styles.teamGrid}>
            {teamMembers.map((member, index) => (
              <div key={index} className={styles.teamCard}>
                <div className={styles.memberImage}>
                  <img
                    src={member.image}
                    alt={member.name}
                    onError={(e) => {
                      e.target.src = '/images/placeholder-avatar.png';
                    }}
                  />
                </div>
                <h3>{member.name}</h3>
                <h4>{member.role}</h4>
                <p>{member.bio}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
};

export default About; 