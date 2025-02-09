import React, { useState } from 'react';
import { Star, Instagram, Facebook, MapPin, Mail, Phone } from 'lucide-react';

const HomePage = () => {
  const [email, setEmail] = useState('');
  const [isValidEmail, setIsValidEmail] = useState(true);
  
  const services = [
    {
      name: "Gel Polish",
      price: "€30",
      description: "inc. detailed cuticle work, natural nail manicure, gel polish application, cuticle oil."
    },
    {
      name: "Builder Gel/biab",
      price: "€35",
      description: "inc. detailed cuticle work, natural nail manicure, builder gel application, file and shape, cuticle oil."
    },
    {
      name: "Acrylic Extensions",
      price: "€40",
      description: "inc. detailed cuticle work, natural nail manicure, acrylic application, file and shape, cuticle oil."
    },
    {
      name: "Gel Polish on Toes",
      price: "€25",
      description: "inc. foot soak, detailed cuticle work, natural nail manicure, gel polish application, cuticle oil."
    },
    {
      name: "Full Pedicure",
      price: "€40",
      description: "inc. foot soak, detailed cuticle work, hard skin removal, natural nail manicure, gel polish application, foot massage."
    },
    {
      name: "Deluxe Pedicure",
      price: "€45",
      description: "inc. foot soak, detailed cuticle work, callus removal treatment, natural nail manicure, gel polish application, foot massage."
    }
  ];

  const additionalServices = [
    { name: "Detailed Nail Art", price: "+€5" },
    { name: "French", price: "+€5" },
    { name: "Removal", price: "+€10" }
  ];

  const validateEmail = (email) => {
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    setIsValidEmail(isValid);
    return isValid;
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (validateEmail(email)) {
      console.log('Form submitted with email:', email);
      setEmail('');
    }
  };

  return (
    <div className="min-h-screen bg-pink-50">
      {/* Hero Section */}
      <section className="relative h-96 bg-pink-200">
        <div className="absolute inset-0 bg-white/20" />
        <div className="container mx-auto px-6 h-full flex items-center">
          <div className="text-center md:text-left max-w-2xl">
            <h1 className="text-4xl md:text-6xl font-serif text-gray-800 mb-4">
              Layla Lawlor Beauty
            </h1>
            <p className="text-xl text-gray-600 mb-8">
              Professional Nail Care & Beauty Services
            </p>
            <button className="bg-pink-400 text-white px-8 py-3 rounded-full hover:bg-pink-500 transition duration-300">
              Book Now
            </button>
          </div>
        </div>
      </section>

      {/* Services Section */}
      <section className="py-16 bg-pink-100">
        <div className="container mx-auto px-6">
          <h2 className="text-3xl font-serif text-center mb-12">Price List</h2>
          <div className="max-w-3xl mx-auto space-y-6">
            {services.map((service, index) => (
              <div key={index} className="bg-white p-6 rounded-lg shadow-sm">
                <div className="flex justify-between items-start mb-2">
                  <h3 className="text-xl font-semibold">{service.name}</h3>
                  <span className="text-lg font-bold text-pink-600">{service.price}</span>
                </div>
                <p className="text-gray-600 text-sm">{service.description}</p>
              </div>
            ))}
            
            <div className="bg-white p-6 rounded-lg shadow-sm">
              <div className="space-y-2">
                {additionalServices.map((service, index) => (
                  <div key={index} className="flex justify-between items-center">
                    <span className="font-semibold">{service.name}</span>
                    <span className="text-pink-600">{service.price}</span>
                  </div>
                ))}
              </div>
              <p className="text-sm text-gray-500 mt-4">
                Refills are the same price as a full set for BIAB or Acrylic
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-serif mb-8">Contact Us</h2>
              <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                  <label className="block text-gray-700 mb-2">Email</label>
                  <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className={`w-full p-3 border rounded-lg ${!isValidEmail ? 'border-red-500' : 'border-gray-300'}`}
                    placeholder="your@email.com"
                  />
                  {!isValidEmail && (
                    <p className="text-red-500 text-sm mt-1">Please enter a valid email address</p>
                  )}
                </div>
                <textarea
                  className="w-full p-3 border border-gray-300 rounded-lg h-32"
                  placeholder="Your message"
                />
                <button
                  type="submit"
                  className="bg-pink-400 text-white px-6 py-3 rounded-lg hover:bg-pink-500 transition duration-300"
                >
                  Send Message
                </button>
              </form>
            </div>
            <div>
              <div className="bg-pink-50 p-6 rounded-lg shadow-sm mb-6">
                <h3 className="text-xl font-serif mb-4">Visit Us</h3>
                <div className="space-y-4">
                  <div className="flex items-center">
                    <MapPin className="w-5 h-5 text-pink-400 mr-3" />
                    <p>123 Beauty Lane, Suite 100<br />Los Angeles, CA 90001</p>
                  </div>
                  <div className="flex items-center">
                    <Phone className="w-5 h-5 text-pink-400 mr-3" />
                    <p>(555) 123-4567</p>
                  </div>
                  <div className="flex items-center">
                    <Mail className="w-5 h-5 text-pink-400 mr-3" />
                    <p>contact@laylalawlorbeauty.com</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-pink-900 text-white py-12">
        <div className="container mx-auto px-6">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="mb-8 md:mb-0">
              <h3 className="text-2xl font-serif mb-4">Layla Lawlor Beauty</h3>
              <p className="text-pink-200">Professional Nail Care & Beauty Services</p>
            </div>
            <div className="flex space-x-6">
              <a href="#" className="hover:text-pink-300 transition duration-300">
                <Instagram className="w-6 h-6" />
              </a>
              <a href="#" className="hover:text-pink-300 transition duration-300">
                <Facebook className="w-6 h-6" />
              </a>
            </div>
          </div>
          <div className="border-t border-pink-800 mt-8 pt-8 text-center text-pink-200">
            <p>&copy; 2025 Layla Lawlor Beauty. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  );
};

export default HomePage;