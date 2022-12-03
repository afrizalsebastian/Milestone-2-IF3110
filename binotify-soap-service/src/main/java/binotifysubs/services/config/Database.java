package binotifysubs.services.config;

import java.sql.*;
import io.github.cdimascio.dotenv.*;

public class Database {
    private Connection conn;
    private String url;

    public Database() {
        Dotenv env = Dotenv.load();
        this.url = "jdbc:mysql://" + env.get("HOST") + ":" + env.get("PORT") + "/" + env.get("DB_NAME");
        System.out.println(this.url);

        try {
            System.out.println("Connecting to MySQL...");
            Class.forName("com.mysql.cj.jdbc.Driver");
            this.conn = DriverManager.getConnection(this.url, env.get("USER"), env.get("PASS"));
            System.out.println("MySQL Connected!");
        } catch (Exception err) {
            throw new RuntimeException("Error : " + err.getMessage());
        }

    }

    public Connection getConnection() {
        return this.conn;
    }
}
