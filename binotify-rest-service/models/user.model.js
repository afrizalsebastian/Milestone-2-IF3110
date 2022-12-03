const { Sequelize } = require("sequelize");

module.exports = (sequelize, Sequelize) => {
    const User = sequelize.define('user', {
        user_id : {
            type : Sequelize.INTEGER,
            autoIncrement : true,
            primaryKey : true
        },
        email : {
            type : Sequelize.STRING
        },
        password :{
            type : Sequelize.STRING
        },
        username : {
            type : Sequelize.STRING
        },
        name : {
            type : Sequelize.STRING
        },
        isAdmin : {
            type : Sequelize.INTEGER
        }
        
    });
    return User
};