import { message } from 'antd';

type MessageType = 'success' | 'error' | 'info' | 'warning';

interface NotifyOptions {
  type: MessageType;
  content: string;
  duration?: number;
}

const notify = ({ type, content, duration = 3 }: NotifyOptions) => {
  switch (type) {
    case 'success':
      message.success(content, duration);
      break;
    case 'error':
      message.error(content, duration);
      break;
    case 'info':
      message.info(content, duration);
      break;
    case 'warning':
      message.warning(content, duration);
      break;
    default:
      message.info(content, duration);
      break;
  }
};

export default notify;
