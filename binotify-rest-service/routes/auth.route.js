const { validator } = require('../middleware');
const controller = require('../controller/auth.controller');

module.exports = (app) =>{
    app.use((req, res, next)=>{
        res.header(
            "Access-Control-Allow-Headers",
            "x-access-token, Origin, Content-Type, Accept"
        );
        next();
    });

    app

    app.post(
        '/api/auth/register',
        [validator.isRegexTrue, validator.isExists],
        controller.register
    );

    app.post(
        '/api/auth/login',
        controller.login
    )

    app.post(
        '/api/auth/refresh',
        controller.refresh
    )
}