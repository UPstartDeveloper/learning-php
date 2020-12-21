// import objects from the module (named 'react')
import React from 'react';
import ReactDOM from 'react-dom';

// define an element using JSX
const element = <h1>Hello World</h1>;

// log the new element
console.log(element);

// render the React element (defined above using JSX) on the Real DOM
ReactDOM.render(element, document.getElementById('root'));