require('dotenv').config();
const db = require('../models');
const config = require('../config/auth.config');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

const User = db.user;

exports.register = (req, res)=>{

    User.create({
        email : req.body.email,
        password : bcrypt.hashSync(req.body.password, 8),
        username : req.body.username,
        name : req.body.name,
        isAdmin : 0
    }).then(()=>{
        res.send({message : 'User was registered successfully'});
    })
};

exports.login = (req, res) =>{
    User.findOne({
        where : {
            username : req.body.username
        }
    }).then(user =>{
        if(!user){
            return res.status(404).send({message : 'User Not Found'});
        }

        const passValid = bcrypt.compareSync(
            req.body.password,
            user.password
        )

        if(!passValid){
            return res.status(401).send({
                accessToken : null,
                message : 'Invalid Password!'
            })
        }

        const token = jwt.sign(
            {userId : user.user_id, email : user.email}, 
            config.secret,
            {expiresIn : '30m'}
        );
        
        const refreshToken = jwt.sign(
            {userId : user.user_id},
            config.refresh,
            {expiresIn : '1d'}
        )

        //cookie
        res.cookie('jwt', refreshToken, {
            httpOnly : true,
            sameSite : 'None',
            maxAge : 24 * 60 * 60 * 1000 
        })

        res.cookie('email', user.email, {
            httpOnly : true,
            sameSite : 'None',
            maxAge : 24 * 60 * 60 * 1000 
        })

        res.cookie('userId', user.user_id, {
            httpOnly : true,
            sameSite : 'None',
            maxAge : 24 * 60 * 60 * 1000 
        })

        res.status(200).send({
            userId : user.user_id,
            username : user.username,
            email : user.email,
            name : user.name,
            isAdmin : user.isAdmin,
            accessToken : token
        });
    }).catch(err =>{
        res.status(500).send({message : err.message});
    });
};

exports.refresh = (req, res) => {
    if (req.cookies?.jwt){
        
        const refreshToken = req.cookies.jwt;
        
        jwt.verify(refreshToken, config.refresh, (err, decode) => {
            if(err){
                return res.status(401).send({
                    message : 'Unauthorized'
                });
            }
            else{
                const accessToken = jwt.sign(
                    {userId : req.cookies.userId, email : req.cookies.email}, 
                    config.secret,
                    {expiresIn : '10m'}
                );

                return res.status(200).send({
                    message : 'Refresh Token',
                    accessToken : accessToken
                })
            }
        })
    }else{
        return res.status(401).send({
            message : 'Unauthorized'
        });
    }
}