import React from 'react';
import { Layout } from 'antd';

const { Footer: AntFooter } = Layout;

const Footer: React.FC = () => (
  <AntFooter style={{ textAlign: 'center' }}>
    © {new Date().getFullYear()} Contact App
  </AntFooter>
);

export default Footer;
