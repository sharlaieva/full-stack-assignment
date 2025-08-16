import { Contact } from '../types/contacts';
import notify from '../components/Notification';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8888';

export async function getContacts(): Promise<Contact[]> {
  try {
    const res = await fetch(`${API_URL}/contacts`);
    if (!res.ok) {
      notify({ type: 'error', content: 'Failed to fetch contacts' });
      throw new Error('Failed to fetch contacts');
    }
    const data = await res.json();
    return data.data;
  } catch (err) {
    notify({ type: 'error', content: 'Error while fetching contacts' });
    throw err;
  }
}

export const createContact = async (contact: Omit<Contact, 'id'>): Promise<Contact> => {
  try {
    const response = await fetch(`${API_URL}/contacts`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(contact),
    });

    if (!response.ok) {
      const errorData = await response.json().catch(() => null);
      const msg = errorData?.error?.[0]?.message || 'Failed to create contact';
      notify({ type: 'error', content: msg });
      throw new Error(msg);
    }

    const result = await response.json();
    notify({ type: 'success', content: 'Contact added successfully!' });
    return result.data as Contact;
  } catch (err: any) {
    if (!err.message) notify({ type: 'error', content: 'Eror while creating contact' });
    throw err;
  }
};

export async function deleteContact(id: number): Promise<void> {
  try {
    const res = await fetch(`${API_URL}/contacts/${id}`, { method: 'DELETE' });
    if (!res.ok) {
      notify({ type: 'error', content: 'Failed to delete contact' });
      throw new Error('Failed to delete contact');
    }
    notify({ type: 'success', content: 'Contact deleted successfully!' });
  } catch (err) {
    notify({ type: 'error', content: 'Error while deleting contact' });
    throw err;
  }
}
