import React, { useState } from "react";
import {  FaCheck } from 'react-icons/fa';
import { useFormik } from "formik";
import * as yup from 'yup';

interface editField{
    id : number,
    title : string,
    path : string
}


const EditModal = (props:any) => {
    const [editModal, setEditModal] = useState(true)
    const onSubmit = () => {
        console.log("Submitted bro");
    }

    const { values, errors, touched, isSubmitting, handleBlur, handleChange, handleSubmit } = useFormik({
        initialValues: {
            id: props.id,
            title: "",
            path: "",
            //songFile:
        },
        onSubmit,
    })
    const [editField, setEditField] = useState<editField>({
        id: props,
        title: "",
        path: ""
    });
    const toggleEditModal = () => {
        setEditModal(!editModal)
    }

    return (
        <div>
            {editModal && (
                <div className="bg-Black1Spotify bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
                    <div className="bg-Black2Spotify px-16 py-14 rounded-md text-center">
                        <h1 className="text-2xl mb-4 font-bold text-white">Edit</h1>
                        <span className="px-4 text-md text-white">New Title</span><br/>
                            <input 
                                className="py-1 px-4 rounded-md"
                                value={values.title}
                                id="username"
                                type="text"
                                placeholder="Enter a new title."
                                /><br/><br/>
                        <span className="px-4 text-md text-white">Import Song</span><br/>
                            <input 
                                className="py-1 px-4 rounded-md text-white"
                                value={values.path}
                                id="newfile"
                                type="file"
                                accept=".mp3, audio/*"
                                placeholder="Input file."
                                /><br/>
                                <br/><br/>
                        <button onClick={toggleEditModal} className="bg-red-500 px-4 py-2 rounded-md text-md text-white">No</button>
                        <button className="bg-lime-500 px-7 py-2 ml-2 rounded-md text-md text-white font-semibold">Yes</button>
                    </div>
                </div>
            )}
        </div>
    )
}

export default EditModal;