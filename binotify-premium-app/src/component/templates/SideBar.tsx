import { useState } from 'react';
import { FaSpotify, FaBars, FaUserCircle } from 'react-icons/fa'

const SideBar = () => {
    const [showNavBar, setShowNavBar] = useState(true)

    const clickNavBar = () => {
        setShowNavBar(!showNavBar);
    }
 
    return(
        <div className='bg-Black1Spotify sm:h-screen sm:w-72 md:w-72 lg:w-80'>
            <div className="grid grid-cols-3 py-3 px-6 items-center sm:px-0 ">
                <FaSpotify className="col-start-2 sm:col-start-1 place-self-center" color='lime' size={50}/>
                <div className='hidden sm:block text-white font-bold'> Binotify Premium</div>
                    <FaBars id="dropdownMenu" className="col-start-3 place-self-end self-center sm:hidden" color='white' onClick={clickNavBar} size={30}/>
            </div>
            { showNavBar?
            <div id='navMenu' className=' px-6 pb-4 divide-y divide-white sm:py-10'>
                <div className=''>
                    <div className='flex sm:flex-wrap sm:hidden '>
                        <FaUserCircle className="justify-center" color='white' size={40}/>
                        <div className='self-center pl-6 '>
                            <div className='text-white font-bold text-xl'>UserName</div>
                            <div className='text-white hidden sm:block'>UserName@UserName.com</div>
                        </div>
                    </div>
                    <div className='hidden sm:grid sm:place-items-center bg-Black2Spotify rounded-lg py-3'>
                        <FaUserCircle className=" " color='white' size={100}/>
                        <div className='text-white font-bold text-xl'>UserName</div>
                        <div className='text-white hidden sm:block'>UserName@UserName.com</div>
                    </div>
                    <div className='self-center pt-5 pb-4 text-white font-bold text-xl'>
                        You Login As 'singer/admin'
                    </div>
                </div>
                <div className='text-white pt-4 text-xl text-center sm:text-left'>
                    Logout
                </div>
            </div>
                : null
            }
        </div>
    )
}

export default SideBar;