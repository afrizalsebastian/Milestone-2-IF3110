import { FaSpotify } from "react-icons/fa";
import BgImage from "../../assets/kawai-login.png";
import AuthService from "../../services/auth-service";
import LoginSchema from "../libs/LoginFieldSchema"
import { useFormik } from "formik";
import { useNavigate } from "react-router-dom";





const Login = () => {
    const navigate = useNavigate();

    const onSubmit = () => {
        AuthService.login(values.username, values.password);
        const data = AuthService.getCurrentUser();
        console.log(typeof(data.isAdmin));
        if(data.isAdmin){
            navigate('/admin-dashboard')
        }else{
            navigate('/singer-dashboard')
        }
    }

    const { values, errors, touched, isSubmitting, handleBlur, handleChange, handleSubmit } = useFormik({
        initialValues: {
           // email: "",
            password: "",
            username: "",
            //name: "",
            //isAdmin: false,
        },
        validationSchema: LoginSchema,
        onSubmit,
    })

    const toRegister = () => {
        navigate('/register')
    }

    

    console.log(errors)
    const styleInputBox = "border border-slate-600 py-2 mb-2 text-black font-normal px-5 rounded-lg w-full max-w-xl ";
    return(
        <div className="h-full w-full">
            <img src={BgImage} className="h-full absolute mix-blend-multiply right-0 bottom-0"/>
            <div className='grid bg-white h-full col-1 place-content-center'>
                <div className='py-2 flex gap-2 font-bold place-content-center place-items-center text-4xl'>
                    <FaSpotify size="60"/>
                    <h1>Binotify Premium</h1>
                </div>
                <form onSubmit={handleSubmit} id='form' className='grid grid-1 font-bold mx-12 mt-24'>
                    <span className="px-4">Username</span>
                    <input 
                        value={values.username}
                        onChange={handleChange}
                        id="username"
                        type="username"
                        placeholder="Enter your username."
                        onBlur ={handleBlur}
                        className={errors.username && touched.username ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    <span  className="px-4 pt-3">Password</span>
                    <input 
                        value={values.password}
                        onChange={handleChange}
                        id="password"
                        type="password"
                        placeholder="Enter your password."
                        onBlur ={handleBlur}
                        className={errors.password && touched.password ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    <div className='mt-5 flex place-content-center place-items-center font-bold text-lg '>
                        <button disabled={isSubmitting} type="submit" className='py-2 px-4 rounded-full bg-Green2Spotify'>Login</button>
                    </div>
                </form>
                <hr className="mt-8 h-px bg-gray-200 border-0 dark:bg-gray-700"></hr>
                <div className='flex gap-2 font-bold place-content-center my-1'>
                    <span>Don't have an account?</span>
                </div>
                <div className='mt-5 flex place-content-center place-items-center font-bold text-lg '>
                    <button className='w-full py-2 px-4 rounded-full border border-slate-600 text-slate-600' onClick={toRegister}>Sign up</button>
                </div>
            </div>
        </div>
    )
}

export default Login;