import { Contact } from '../types/contacts';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8888';

export async function getContacts(): Promise<Contact[]> {
  const res = await fetch(`${API_URL}/contacts`);
  if (!res.ok) throw new Error('Failed to fetch contacts');
  const data = await res.json();
  return data.data;
}

export const createContact = async (contact: Omit<Contact, 'id'>): Promise<Contact> => {
  const response = await fetch(`${API_URL}/contacts`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(contact),
  });

  if (!response.ok) {
    throw new Error('Failed to create contact');
  }

  const result = await response.json();

  return result.data as Contact;
};

export async function deleteContact(id: number): Promise<void> {
  const res = await fetch(`${API_URL}/contacts/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Failed to delete contact');
}
