import React from 'react';
import { Button as AntButton, ButtonProps } from 'antd';

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>((props, ref) => {
  return <AntButton ref={ref} {...props} />;
});

export default Button;
