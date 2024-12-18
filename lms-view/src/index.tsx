
import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import './index.css';
// import axios, { AxiosError } from "axios";
// import UINotify from "./Components/UINotify";
const root = ReactDOM.createRoot(
    document.getElementById('root') as HTMLElement
  );
  const url = window.location.href; 
  root.render(
    // <React.StrictMode>
        <App />
    // </React.StrictMode>
  );