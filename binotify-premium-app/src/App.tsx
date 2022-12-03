import './App.css'
import { BrowserRouter, Routes, Route } from 'react-router-dom';
//Pages
import Login from './component/pages/Login';
import Register from './component/pages/Register';
import SingerDashboard from './component/pages/SingerDashboard';
import AdminDashboard from './component/pages/AdminDashboard';
import AcceptModal from './component/templates/admin/AcceptModal';
import DeleteModal from './component/templates/singer/DeleteModal';
import EditModal from './component/templates/singer/EditModal';
import RejectModal from './component/templates/admin/RejectModal';

function App() {
	return(
		<div className='h-screen bg-gradient-to-b from-Grey1Spotify via-gray-900 to-Black2Spotify'>
			<BrowserRouter>
				<Routes>
					{/* public routes */}
					<Route path='/' element={<Login/>}/>
					<Route path='/register' element={<Register/>}/>
					
					{/* singer role routes */}
					<Route path='/admin-dashboard' element={<AdminDashboard/>} />
					
					{/* admin role routes */}
					<Route path='/singer-dashboard' element={<SingerDashboard/>} />
				</Routes>
			</BrowserRouter>
		</div>
	);
}

export default App
