import React, { useState } from 'react';
import ContactList from '../components/ContactList';
import { useContacts } from '../hooks/useContacts';
import AddContactModal from '../components/AddContactModal';
import { Contact } from '../types/contacts';
import Button from '../components/Button';

const ContactsPage: React.FC = () => {
  const { contacts, addContact, removeContact, loading } = useContacts();
  const [modalVisible, setModalVisible] = useState(false);

  const openModal = () => setModalVisible(true);
  const closeModal = () => setModalVisible(false);

  const handleAddContact = async (contact: Omit<Contact, 'id'>) => {
    await addContact(contact);
    closeModal();
  };

  return (
    <div>
      <h2>Contacts</h2>
      <Button onClick={openModal} style={{ marginBottom: 16 }}>
        Add Contact
      </Button>

      <AddContactModal
        visible={modalVisible}
        onClose={closeModal}
        onSubmit={handleAddContact}
      />

      <ContactList contacts={contacts} onDelete={removeContact} loading={loading} />
    </div>
  );
};

export default ContactsPage;
