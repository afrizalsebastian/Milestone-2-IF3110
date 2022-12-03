import React, { useState } from "react";

const RejectModal = () => {
    return (
        <div className="bg-Black1Spotify bg-opacity-50 flex justify-center items-center absolute top-0 right-0 bottom-0 left-0">
            <div className="bg-Black2Spotify px-16 py-14 rounded-md text-center">
                <h1 className="text-xl mb-4 font-bold text-white">Are you sure want reject this user?</h1>
                <button className="bg-red-500 px-4 py-2 rounded-md text-md text-white">Cancel</button>
                <button className="bg-lime-500 px-7 py-2 ml-2 rounded-md text-md text-white font-semibold">Yes</button>
            </div>
        </div>
    )
}

export default RejectModal;