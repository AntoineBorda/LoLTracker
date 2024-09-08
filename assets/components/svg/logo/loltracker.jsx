import React from 'react';

const Logo = ({ className = 'w-6 h-6', strokeColor = 'currentColor' }) => (
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" className={className}>
      <rect width="100" height="100" fill="none"></rect>
      <path d="M10 30 Q10 10 30 10 L70 10 Q90 10 90 30 L90 70 Q90 90 70 90 L30 90 Q10 90 10 70 Z"
            stroke={strokeColor} strokeWidth="6" fill="none" />
      <path d="M20 80 Q50 50 80 20" stroke={strokeColor} strokeWidth="6" fill="none" />
  </svg>
);

export default Logo;
