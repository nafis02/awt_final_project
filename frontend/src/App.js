import './App.css';
import "bootstrap/dist/css/bootstrap.min.css";
import {Routes, Route, Link } from "react-router-dom";
import Home from './pages/home'
import Create from './pages/create'
import Edit from './pages/edit'
import View from './pages/view'
import Login from './Components/Frontend/Login'
import AddProduct from './pages/AddProduct';

function App() {
  return (
    <div>
      <nav className='navbar navbar-expand navbar-dark bg-dark'>
        <div className='navbar-nav mr-auto'>
          <li className='nav-item'>
            <Link to={"/"} className="nav-link">Customer List</Link>
          </li>
          
          <li className='nav-item'>
            <Link to={"/login"} className="nav-link">Login</Link>
          </li>
          
          <li className='nav-item'>
            <Link to={"/create"} className="nav-link">Register</Link>
          </li>

          <li className='nav-item'>
            <Link to={"/AddProduct"} className="nav-link">Add Product</Link>
          </li>

         

         
        </div>
      </nav>
      <div className='container'>
        <Routes>
          <Route path='/' element={<Home />} />
          <Route path='/create' element={<Create />} />
          <Route path='/edit/:id' element={<Edit />} />
          <Route path='/view/:id' element={<View />} />
          <Route path='/login' element={<Login />} />
          <Route path='/AddProduct' element={<AddProduct />} />
          
        </Routes>
      </div>
    </div>
  );
}

export default App;