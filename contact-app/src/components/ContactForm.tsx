import React from 'react';
import { Form, Input } from 'antd';
import type { FormInstance, InputRef } from 'antd';
import { ContactFormData } from '../types/contacts';

interface ContactFormProps {
  form: FormInstance<ContactFormData>;
  firstInputRef?: React.RefObject<InputRef | null>;
}

const ContactForm: React.FC<ContactFormProps> = ({ form, firstInputRef }) => (
  <>
    <Form.Item
      name="name"
      label="Name"
      rules={[
      { required: true, message: 'Name is required' },
      { pattern: /^[^\d]*$/, message: 'Name cannot contain digits' },
      ]}
    >
      <Input ref={firstInputRef} placeholder="Enter name" />
    </Form.Item>
    <Form.Item
      name="email"
      label="Email"
      rules={[
        { required: true, message: 'Email is required' },
        { type: 'email', message: 'Enter a valid email' },
      ]}
    >
      <Input placeholder="Enter email" />
    </Form.Item>
  </>
);

export default ContactForm;
