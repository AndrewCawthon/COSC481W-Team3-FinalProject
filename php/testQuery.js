const sql = require('mssql');

const config = {
    user: 'mainLogin', // better stored in an app setting such as process.env.DB_USER
    password: 'AdminUser42!', // better stored in an app setting such as process.env.DB_PASSWORD
    server: 'test-server-seniorproject.database.windows.net', // better stored in an app setting such as process.env.DB_SERVER
    port: 1433, // optional, defaults to 1433, better stored in an app setting such as process.env.DB_PORT
    database: 'test', // better stored in an app setting such as process.env.DB_NAME
    authentication: {
        type: 'default'
    },
    options: {
        encrypt: true
    }
}

async function connectAndQuery() {
    try {
        let pool = await sql.connect(config)
        let result1 = await pool.request()
            .query("SELECT * FROM schedule");
        console.dir(result1)
        pool.close();
    } catch (err) {
        console.log(err)
    }
}

connectAndQuery();
