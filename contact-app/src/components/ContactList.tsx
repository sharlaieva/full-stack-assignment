import React from 'react';
import { Table, Popconfirm } from 'antd';
import { Contact } from '../types/contacts';
import Button from './Button';

interface Props {
  contacts: Contact[];
  onDelete: (id: number) => void;
  loading?: boolean;
}

const ContactList: React.FC<Props> = ({ contacts, onDelete, loading }) => {
  const columns = [
    { title: 'Name', dataIndex: 'name', key: 'name' },
    { title: 'Email', dataIndex: 'email', key: 'email' },
    {
      title: 'Action',
      key: 'action',
      render: (_: unknown, record: Contact) => (
        <Popconfirm
          title="Do you really want to delete contact?"
          onConfirm={() => onDelete(record.id)}
        >
          <Button danger>Delete</Button>
        </Popconfirm>
      ),
    },
  ];

  return (
    <Table
      rowKey="id"
      dataSource={contacts}
      columns={columns}
      pagination={false}
      loading={loading}
    />
  );
};

export default ContactList;
