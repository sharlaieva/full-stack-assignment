import React, { useState } from 'react';
import { Table, Popconfirm, Pagination } from 'antd';
import { Contact } from '../types/contacts';
import Button from './Button';

interface Props {
  contacts: Contact[];
  onDelete: (id: number) => void;
  loading?: boolean;
}

  const PAGE_SIZE = 10;

  const ContactList: React.FC<Props> = ({ contacts, onDelete, loading }) => {
  const [currentPage, setCurrentPage] = useState(1);

  const sortedContacts = [...contacts].sort((a, b) => b.id - a.id);
  const startIndex = (currentPage - 1) * PAGE_SIZE;
  const paginatedContacts = sortedContacts.slice(startIndex, startIndex + PAGE_SIZE);


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
    <>
      <Table
        rowKey="id"
        dataSource={paginatedContacts}
        columns={columns}
        pagination={false}
        loading={loading}
      />
      {contacts.length > PAGE_SIZE && (
        <Pagination
          current={currentPage}
          pageSize={PAGE_SIZE}
          total={contacts.length}
          onChange={page => setCurrentPage(page)}
          style={{ marginTop: 16, textAlign: 'center' }}
        />
      )}
    </>
  );
};

export default ContactList;
