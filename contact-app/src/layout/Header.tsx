import React from 'react';
import { Layout } from 'antd';

const { Header: AntHeader } = Layout;

const Header: React.FC = () => (
  <AntHeader style={{ color: 'white' }}>
    Contact App
  </AntHeader>
);

export default Header;
