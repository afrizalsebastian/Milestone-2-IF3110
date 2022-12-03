import axios from "axios";
import React, { useState } from "react";
import {  FaCheck } from 'react-icons/fa'
import AuthService from "../../../services/auth-service";


const DeleteModal = (props:any) => {
    const [deleteModal, setDeleteModal] = useState(true)
    const user = AuthService.getCurrentUser();
    const toggleDeleteModal = () => {
        setDeleteModal(!deleteModal)
        console.log("Test");
    }

    const deleteSong = () => {
        axios.delete(`http://localhost:4000/api/song/query?id=${props.id}`, {
            headers : {
                'x-access-token' : user.accessToken
            }
        }).then(response => {
            console.log(response);
            setDeleteModal(!deleteModal);
            window.location.reload();
        })
    }
    return (
        <div>
            {deleteModal && (
                <div className="bg-Black1Spotify bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                    <div className="bg-Black2Spotify px-16 py-14 rounded-md text-center">
                        <h1 className="text-xl mb-4 font-bold text-white">Are you sure want to delete this song?</h1>
                        <button onClick={toggleDeleteModal} className="bg-red-500 px-4 py-2 rounded-md text-md text-white">No</button>
                        <button className="bg-lime-500 px-7 py-2 ml-2 rounded-md text-md text-white font-semibold" onClick={deleteSong}>Yes</button>
                    </div>
                </div>
            )}
        </div>
    )
}

export default DeleteModal;