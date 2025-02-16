import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Home from './pages/Home';
import About from './pages/About';
import Services from './pages/Services';
import Portfolio from './pages/Portfolio';
import Contact from './pages/Contact';
import Booking from './pages/Booking';
import Admin from './pages/Admin';
import AdminLogin from './pages/Admin/Login';
import ProtectedRoute from './components/ProtectedRoute';
import 'react-datepicker/dist/react-datepicker.css';
import BookingConfirmation from './pages/BookingConfirmation';
import './App.css';

function App() {
  return (
    <div className="App">                                                       
      <Routes>
        <Route path="/" element={<><Navbar /><Home /></>} />
        <Route path="/about" element={<><Navbar /><About /></>} />
        <Route path="/services" element={<><Navbar /><Services /></>} />
        <Route path="/portfolio" element={<><Navbar /><Portfolio /></>} />
        <Route path="/contact" element={<><Navbar /><Contact /></>} />
        <Route path="/booking" element={<><Navbar /><Booking /></>} />
        <Route path="/booking/confirmation" element={<BookingConfirmation />} />
        <Route path="/admin/login" element={<AdminLogin />} />
        <Route 
          path="/admin/*" 
          element={
            <ProtectedRoute>
              <Admin />
            </ProtectedRoute>
          } 
        />
      </Routes>
    </div>
  );
}

export default App;
