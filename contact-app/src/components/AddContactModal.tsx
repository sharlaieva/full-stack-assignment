import React, { useRef, useEffect } from 'react';
import { Modal, Form, InputRef } from 'antd';
import Button from './Button';
import ContactForm from './ContactForm';
import { ContactFormData } from '../types/contacts';

interface Props {
  visible: boolean;
  onClose: () => void;
  onSubmit: (data: ContactFormData) => void;
}

const AddContactModal: React.FC<Props> = ({ visible, onClose, onSubmit }) => {
  const [form] = Form.useForm<ContactFormData>();
  const firstInputRef = useRef<InputRef | null>(null);

  useEffect(() => {
    if (visible) {
      setTimeout(() => firstInputRef.current?.focus(), 100);
    }
  }, [visible]);

  const handleFinish = (values: ContactFormData) => {
    onSubmit(values);
    form.resetFields();
    onClose();
  };

  return (
    <Modal
      title="Add Contact"
      open={visible}
      onCancel={() => {
        form.resetFields();
        onClose();
      }}
      footer={[
        <Button key="cancel" onClick={() => { form.resetFields(); onClose(); }}>Cancel</Button>,
        <Button key="save" type="primary" onClick={() => form.submit()}>Save</Button>
      ]}
      destroyOnHidden
    >
      <Form
        form={form}
        layout="vertical"
        onFinish={handleFinish}
      >
        <ContactForm form={form} firstInputRef={firstInputRef} />
      </Form>
    </Modal>
  );
};

export default AddContactModal;
