import { useEffect, useState } from 'react';
import { getContacts, createContact, deleteContact } from '../api/contacts';
import { Contact } from '../types/contacts';

export const useContacts = () => {
  const [contacts, setContacts] = useState<Contact[]>([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    (async () => {
      setLoading(true);
      try {
        const contactsFromApi = await getContacts();
        setContacts(contactsFromApi);
      } catch (error) {
        console.error('Failed to load contacts', error);
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  const addContact = async (contact: Omit<Contact, 'id'>) => {
  try {
    const newContact = await createContact(contact);
    setContacts(prev => [...prev, newContact]);
  } catch (error) {
    console.error('Failed to add contact', error);
  }
};

  const removeContact = async (id: number) => {
    try {
      await deleteContact(id);
      setContacts(prev => prev.filter(c => c.id !== id));
    } catch (error) {
      console.error('Failed to delete contact', error);
    }
  };

  return { contacts, addContact, removeContact, loading };
};
