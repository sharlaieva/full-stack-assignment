import React, { useState } from 'react';
import { Modal } from 'antd';
import Button from './Button';
import ContactForm from './ContactForm';
import { ContactFormData, initialFormData } from '../types/contacts';

interface Props {
  visible: boolean;
  onClose: () => void;
  onSubmit: (data: ContactFormData) => void;
}

const AddContactModal: React.FC<Props> = ({ visible, onClose, onSubmit }) => {
  const [formData, setFormData] = useState<ContactFormData>(initialFormData);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const resetForm = () => setFormData(initialFormData);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit(formData);
    resetForm();
  };

  const handleClose = () => {
    resetForm();
    onClose();
  };

  return (
    <Modal
      title="Add Contact"
      open={visible}
      onCancel={handleClose}
      footer={[
        <Button key="cancel" onClick={handleClose} className="mb-2">
          Cancel
        </Button>,
        <Button
          key="save"
          htmlType="submit"
          form="contact-form"
          type="primary"
          className="mb-2"
        >
          Save
        </Button>,
      ]}
      destroyOnHidden
    >
      <form id="contact-form" onSubmit={handleSubmit}>
        <ContactForm formData={formData} onChange={handleChange} />
      </form>
    </Modal>
  );
};

export default AddContactModal;
