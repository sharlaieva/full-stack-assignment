export interface Contact {
  id: number;
  name: string;
  email: string;
}

export interface ContactsResponse {
  maxIndex: number;
  data: Contact[];
}

export type ContactFormData = Omit<Contact, 'id'>;

export const initialFormData: ContactFormData = {
  name: '',
  email: '',
};