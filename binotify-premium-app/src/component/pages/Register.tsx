import { FaSpotify } from 'react-icons/fa'
import BgImage from "../../assets/kawai-register.png";
import RegisterSchema from '../libs/RegisterFieldSchema';
import { useFormik } from 'formik';
import AuthService from "../../services/auth-service";
import { useNavigate } from 'react-router-dom';


const Register = () => {
    const navigate = useNavigate()
    const onSubmit = () => {
        AuthService.register(values.email, values.password, values.username, values.name)
    }
    const { values, errors, touched, isSubmitting, handleBlur, handleChange, handleSubmit } = useFormik({
        initialValues: {
            email: "",
            password: "",
            confirmPassword: "",
            username: "",
            name: "",
            //isAdmin: false,
        },
        validationSchema: RegisterSchema,
        onSubmit,
    })

    const toLogin = () =>{
        navigate('/')
    }

    console.log(errors)
    const styleInputBox = "border border-slate-600 py-2  text-black font-normal px-5 rounded-lg w-full max-w-xl ";
    return(
        <div className='h-full'>
            <img src={BgImage} className="h-full absolute mix-blend-multiply left-5 bottom-0"/>
            <div className='grid bg-white h-full place-content-center '>
                <div className='py-2 flex gap-2 font-bold place-content-center place-items-center md:text-lg'>
                    <FaSpotify size="40"/>
                    <h1>Binotify Premium</h1>
                </div>
                <div className="pt-0 grid grid-col-1 gap-0 place-content-center font-extrabold text-lg md:text-xl">
                    <span className='w-64 text-center'>Sign up for free to start manage your music</span>
                </div>
                <form onSubmit={handleSubmit} id='form' className='grid grid-1 font-bold gap-1 mx-12 mt-10'>
                    <span className='mt-3'>What's your name?</span>
                    <input 
                        value={values.name}
                        onChange={handleChange}
                        id="name"
                        type="text"
                        placeholder="Enter your name."
                        onBlur ={handleBlur}
                        className={errors.name && touched.name ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    {errors.name && touched.name && <p className="font-normal text-rose-500">{errors.name}</p>}
                    <span className='mt-3'>What should we call you?</span>
                    <input 
                        value={values.username}
                        onChange={handleChange}
                        id="username"
                        type="text"
                        placeholder="Enter a username."
                        onBlur ={handleBlur}
                        className={errors.username && touched.username ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    {errors.username && touched.username && <p className="font-normal text-rose-500">{errors.username}</p>}
                    <span className='mt-3'>What's your email?</span>
                    <input 
                        value={values.email}
                        onChange={handleChange}
                        id="email"
                        type="email"
                        placeholder="Enter your email."
                        onBlur ={handleBlur}
                        className={errors.email && touched.email ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    {errors.email && touched.email && <p className="font-normal text-rose-500">{errors.email}</p>}
                    <span className='mt-3'>Create a password</span>
                    <input 
                        value={values.password}
                        onChange={handleChange}
                        id="password"
                        type="password"
                        placeholder="Create a password."
                        onBlur ={handleBlur}
                        className={errors.password && touched.password ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    {errors.password && touched.password && <p className="font-normal text-rose-500">{errors.password}</p>}
                    <span className='mt-3'>Confirm your password</span>
                    <input 
                        value={values.confirmPassword}
                        onChange={handleChange}
                        id="confirmPassword"
                        type="password"
                        placeholder="Enter your password again."
                        onBlur ={handleBlur}
                        className={errors.confirmPassword && touched.confirmPassword ? styleInputBox + "border-rose-500" : styleInputBox}/>
                    {errors.confirmPassword && touched.confirmPassword && <p className="font-normal text-rose-500">{errors.confirmPassword}</p>}
                <div className='mt-5 flex place-content-center place-items-center font-bold text-lg '>
                    <button disabled={isSubmitting} type="submit" className='py-2 px-4 rounded-full bg-Green2Spotify'>Sign up</button>
                </div>
                </form>
                <div className='flex gap-2 font-bold place-content-center my-1'>
                    <span>Have an account?</span>
                    <a href="#" className='text-Green2Spotify underline underline-offset-2 ' onClick={toLogin}>Log in</a>
                </div>
            </div>
        </div>
    )
}/*
<div className="bg-white grid grid-cols-1 justify-center h-full">
<div className='place-self-center flex items-center gap-1 py-2 font-bold'>
<FaSpotify size="30"/>
Binotify Premium
</div>
<div className='place-self-center flex items-center gap-1 py-2 font-bold'>
<FaSpotify size="30"/>
Binotify Premium
</div>
</div>
*/

export default Register;