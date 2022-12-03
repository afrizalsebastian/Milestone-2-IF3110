import * as yup from "yup";


const LoginSchema = yup.object().shape({
    username: yup.string().required("Required"),
    password: yup.string().required("Required")
})

export default LoginSchema;