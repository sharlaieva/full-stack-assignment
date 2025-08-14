import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import MainLayout from './layout/MainLayout';
import ContactsPage from './pages/ContactsPage';
import 'antd/dist/reset.css';

const App: React.FC = () => {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<MainLayout />}>
          <Route index element={<ContactsPage />} />
        </Route>
      </Routes>
    </Router>
  );
};

export default App;
