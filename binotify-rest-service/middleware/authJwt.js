const jwt = require('jsonwebtoken');
const config = require('../config/auth.config');
const db = require('../models');
const User = db.user;


verifyToken = (req, res, next) => {
    let token = req.headers["x-access-token"];

    const { TokenExpiredError } = jwt;

    if(!token){
        return res.status(403).send({
            message : 'No Token Provided'
        })
    }

    jwt.verify(token, config.secret, (err, decode) => {
        if(err){
            if (err instanceof TokenExpiredError) {
                return res.status(401).send({message : "Unauthorized! Your Token was Expired"});
            }
            
            return res.status(401).send({
                message : 'Unauthorized'
            });
        }
        
        req.userId = decode.userId;
        next();
    });
};

isAdmin = (req, res, next) => {
    User.findByPk(req.userId).then(user=>{
        if(user.isAdmin === 1){
            next();
            return;
        }

        res.status(403).send({
            message : 'Require Admin Role!'
        });
        return;
    })
}

const authJwt = {
    verifyToken : verifyToken,
    isAdmin : isAdmin
}

module.exports = authJwt;