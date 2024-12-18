import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
// import Student from './Components/Student/Student.Component';
import Student from './componant/Studen';
const App: React.FC  = () => {
  var url = window.location.pathname;
  var baseURL = url.split("/Pages")[0];
  return (
    <div>
    <Router>
      <Routes>
        
        <Route path={'react'}element={<Student />} />
            </Routes>
    </Router>
    </div>
  );
}
  


export default App;