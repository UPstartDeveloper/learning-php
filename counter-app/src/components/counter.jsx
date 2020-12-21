 import React, { Component } from 'react';

 // first React Component!
 class Counter extends Component {
     // when rendered, this component renders a header
     render() { 
         return (
         <React.Fragment>
            <h1>Hello World</h1>
            <button>Increment</button>
         </React.Fragment>
        );
     }
 }
  
 export default Counter;