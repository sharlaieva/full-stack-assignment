import React from 'react';
import { Outlet } from 'react-router-dom';
import { Card } from 'antd';
import Header from './Header';
import Footer from './Footer';

const MainLayout: React.FC = () => {
  return (
    <div
      style={{
        display: 'flex',
        flexDirection: 'column',
        minHeight: '100vh',
      }}
    >
      <Header />
      <main style={{ flex: 1, display: 'flex', justifyContent: 'center', padding: '20px' }}>
        <Card style={{ width: '100%', maxWidth: 800 }}>
          <Outlet />
        </Card>
      </main>
      <Footer />
    </div>
  );
};

export default MainLayout;
