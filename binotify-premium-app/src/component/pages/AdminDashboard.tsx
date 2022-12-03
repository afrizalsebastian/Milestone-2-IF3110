import {  FaCheck, FaTimes, FaPlus } from 'react-icons/fa'
import React, { useEffect, useState } from "react";
import SideBar from '../templates/SideBar';
import AuthService from "../../services/auth-service";
import axios from 'axios';


<div>
    <SideBar/>
</div>
const AdminDashboard = () => {
    const [subsreq, setSubsreq] = useState<any[]>([]);
    const user = AuthService.getCurrentUser();
    console.log(user.userId);
    

    useEffect(() => {
        const fetchData = async () =>{
            try{
                const {data} = await axios.get(
                    `http://localhost:4000/api/subsRequest/pending`, {
                        headers : {
                            'x-access-token' : user.accessToken
                        }
                    }
                );

                setSubsreq(data.return);
                
            }catch (err){
                console.log(err);
            }
        };

        fetchData();
    }, [user.userId]);

    return (
        <div className='sm:flex'>
            <div>
                <SideBar/>
            </div>
            <div>
                <div className='pt-10 mx-16 flex justify-between'>
                    <h2 className=" mb-2 font-bold text-3xl text-white ">Subscription List</h2>
                </div>
                <div className="container mt-10 mx-auto px-6 grid grid-cols-1 2xl:grid-cols-2 gap-2 sm:text-sm lg:text-lg">
                    {
                        subsreq.map((subs, key) => (
                            <div className="hover:shadow-lime-500 rounded bg-Black1Spotify shadow-xl py-3  flex justify-between sm:w-max sm:mb-0" key={key}>
                                <div className="flex justify-start">
                                    <div className="font-bold  text-white px-4 self-center">{key+1}</div>
                                    <div className=" text-white px-3">{subs.subscriberName}</div>
                                    <div className=" text-white px-3">{subs.creatorName}</div>
                                </div>
                                <div className="flex justify-end lg:hidden">
                                    <div className="mx-1 px-4 py-2 bg-lime-500 flex rounded-full">
                                        < FaCheck size={25} className='self-center'  />
                                    </div>
                                    <div className="mx-4 px-4 py-2 bg-rose-500 flex rounded-full">
                                        <FaTimes size={25} className='self-center' />
                                    </div>
                                </div>
                                <div className="hidden lg:flex lg:justify-end font-bold">
                                <div className="mx-1 px-4 py-2 bg-lime-500 flex rounded-full active:bg-lime-800 ">
                                        < FaCheck size={25} className='self-center'  /> Accept
                                    </div>
                                    <div className="mx-4 px-4 py-2 bg-rose-500 flex rounded-full active:bg-rose-800">
                                        <FaTimes size={25} className='self-center' /> Reject
                                    </div>
                                </div>
                            </div> 
                        ))
                    }
                </div>
            </div>
        </div>
    )
}

export default AdminDashboard;