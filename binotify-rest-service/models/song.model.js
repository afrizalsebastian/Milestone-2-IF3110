const { Sequelize } = require("sequelize");

module.exports = (sequelize, Sequelize) =>{
    const Song = sequelize.define('song', {
        song_id : {
            type : Sequelize.INTEGER,
            autoIncrement : true,
            primaryKey : true
        },
        judul : {
            type : Sequelize.STRING
        },
        audio_path : {
            type : Sequelize.STRING
        }
    });

    return Song;
};