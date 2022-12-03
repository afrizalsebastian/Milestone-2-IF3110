package binotifysubs.services.controller;

import binotifysubs.services.config.Database;
import binotifysubs.services.model.Logging;

import java.sql.*;

public class LogController {

    public void insert(Logging log) {
        String query = "INSERT INTO Logging (description, ip, endpoint, requested_at) VALUES (?, ?, ?, ?)";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            value.setString(1, log.getDescription());
            value.setString(2, log.getIp());
            value.setString(3, log.getEndpoint());
            value.setTimestamp(4, log.getRequestAt());

            value.execute();
        } catch (Exception err) {
            throw new RuntimeException("Error" + err.getMessage());
        }
    }
}
