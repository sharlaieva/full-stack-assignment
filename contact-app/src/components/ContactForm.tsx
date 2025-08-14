import React from 'react';
import { Input } from 'antd';
import { ContactFormData } from '../types/contacts';

interface ContactFormProps {
  formData: ContactFormData;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
}

const ContactForm: React.FC<ContactFormProps> = ({ formData, onChange }) => {
  return (
    <>
      {Object.keys(formData).map(key => (
        <Input
          key={key}
          type={key === 'email' ? 'email' : 'text'}
          name={key}
          value={formData[key as keyof ContactFormData]}
          onChange={onChange}
          placeholder={key.charAt(0).toUpperCase() + key.slice(1)}
          style={{ marginBottom: 12 }}
          required
        />
      ))}
    </>
  );
};

export default ContactForm;
