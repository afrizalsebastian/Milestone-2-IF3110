import { FaPencilAlt, FaTrashAlt, FaPlus } from 'react-icons/fa'
import React, { useEffect, useState } from "react";
import SideBar from '../templates/SideBar';
import AuthService from "../../services/auth-service";
import AddModal from '../templates/singer/AddModal';
import DeleteModal from '../templates/singer/DeleteModal';
import EditModal from '../templates/singer/EditModal';
import Login from './Login';
import axios from 'axios';

// ToDo : Pagination 18 item per page
const SingerDashboard: React.FC = () => {
    const [addModal, setAddModal] = useState(false)
    const [deleteModal, setDeleteModal] = useState(false)
    const [editModal, setEditModal] = useState(false)

    const [songs, setSongs] = useState<any[]>([]);
    const user = AuthService.getCurrentUser();
    console.log(user.userId);
    

    useEffect(() => {
        const fetchData = async () =>{
            try{
                const {data} = await axios.get(
                    `http://localhost:4000/api/song/query?penyanyi=${user.userId}`, {
                        headers : {
                            'x-access-token' : user.accessToken
                        }
                    }
                );
                
                setSongs(data);
                
            }catch (err){
                console.log(err);
            }
        };

        fetchData();
    }, [user.userId]);

    const toggleAddModal = () => {
        setAddModal(!addModal)
        console.log("Test");
    }
    const toggleDeleteModal = () => {
        setDeleteModal(!deleteModal)
        console.log("Test");
    }
    const toggleEditModal = () => {
        setEditModal(!editModal)
        console.log("Test");
    }
    
    return(
        <div>
            <div className='sm:flex'>
                <div>
                <SideBar/>
                </div>
                <div>
                    <div className='pt-10 mx-16 flex justify-between'>
                        <h2 className=" mb-2 font-bold text-3xl text-white ">Your Songs</h2>
                        <div onClick={toggleAddModal} className="w-16 h-16 square ml-4 rounded-full bg-lime-500 flex items-center justify-center mt-2 active:bg-lime-800">
                            <FaPlus  size={35} color='black'/></div>
                    </div>
                    <div className="container mt-10 mx-auto px-6 sm:flex sm:flex-wrap sm:gap-4 sm:justify-center">
                        {
                            songs.map((song, key) => (
                                <div className="hover:shadow-lime-500 rounded bg-Black1Spotify shadow-xl py-3 mb-10 flex justify-between sm:w-max sm:mb-0" key={key}>
                                    {deleteModal && (
                                        <DeleteModal id={song.song_id}/>
                                    )}
                                    {editModal && (
                                        <EditModal id={song.song_id}/>
                                    )}
                                    <div className="flex justify-start">
                                        <div className="font-bold text-xl text-white px-4">{key+1}</div>
                                        <div className="font-bold text-xl text-white px-3">{song.judul}</div>
                                    </div>
                                    <div className="flex justify-end sm:hidden">
                                        <div onClick={toggleEditModal} className="mx-1 px-4 py-2 bg-lime-500 flex rounded-full">
                                            <FaPencilAlt size={35} />
                                        </div>
                                        <div onClick={toggleDeleteModal} className="mx-4 px-4 py-2 bg-rose-500 flex rounded-full">
                                            <FaTrashAlt size={35}/>
                                        </div>
                                    </div>
                                    <div className="hidden sm:flex sm:justify-end font-bold">
                                        <div onClick={toggleEditModal} className="mx-1 px-4 py-2 bg-lime-500 flex rounded-full active:bg-lime-800">
                                            <FaPencilAlt size={35} /> Edit
                                        </div>
                                        <div onClick={toggleDeleteModal} className="mx-4 px-4 py-2 bg-rose-500 flex rounded-full active:bg-rose-800">
                                            <FaTrashAlt size={35}/> Delete
                                        </div>
                                    </div>
                                </div>
                            ))
                        }
                    </div>
                </div>
            </div>
            {addModal && (
                <AddModal id={user.userId}/>
            )}
        </div>
    )
}

export default SingerDashboard;