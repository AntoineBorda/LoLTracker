import React from 'react';

const Twitch = ({ className = 'w-6 h-6', strokeColor = 'currentColor' }) => (

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 1664" className={className}>
        <path fill={strokeColor} d="M800 434v434H655V434zm398 0v434h-145V434zm0 760l253-254V145H257v1049h326v217l217-217zM1596 0v1013l-434 434H836l-217 217H402v-217H4V289L113 0z" />
    </svg>

);

export default Twitch;
