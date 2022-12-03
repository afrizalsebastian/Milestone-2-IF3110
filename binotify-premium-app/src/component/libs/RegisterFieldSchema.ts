import * as yup from "yup";

// min 5 characters, 1 upper case letter, 1 lower case letter, 1 numeric digit
const passwordRules = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}$/;
// only contain letter, numeric digit, or underscore
const userNameRules = /^[A-Za-z0-9_]*$/;


export const RegisterSchema = yup.object().shape({
    name : yup.string().required("Required"),
    email: yup.string().email("Please enter a valid email").required("Required"),
    username: yup.string().matches(userNameRules, {message : "Please create valid username"}).required("Required"),
    password: yup.string().matches(passwordRules, {message : "Please create a stronger password"}).required("Required"),
    confirmPassword : yup.string().oneOf([yup.ref("password"), null], "Passwords must match").required("Required")

})

export default RegisterSchema;