require('dotenv').config()
const express = require('express');
const cors = require('cors');
const cookieParser = require('cookie-parser');

const app = express();

var corsOption ={
    origin : "*"
};

app.use(cors(corsOption));
app.use(express.json());
app.use(express.urlencoded({extended:true}));
app.use(cookieParser())
const db = require('./models');
db.sequelize.sync();

require('./routes/auth.route')(app);
require('./routes/user.route')(app);



app.get('/', (req, res)=>{
    res.json({message : 'Tubes 2 WBD REST API'});
});

const PORT = process.env.PORT || 8000;

app.listen(PORT, ()=>{
    console.log(`Running in port ${PORT}`);
})
