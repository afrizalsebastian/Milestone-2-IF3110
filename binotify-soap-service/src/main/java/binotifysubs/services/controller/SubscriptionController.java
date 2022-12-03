package binotifysubs.services.controller;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

import binotifysubs.services.config.Database;
import binotifysubs.services.model.Subscription;

public class SubscriptionController {

    public boolean insertSubs(Subscription subs) {
        String query = "INSERT INTO subscription (creator_id,creator_name, subscriber_id, subscriber_name, status) VALUES (?,?,?,?,?)";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            value.setInt(1, subs.getCreatorId());
            value.setString(2, subs.getCreatorName());
            value.setInt(3, subs.getSubscriberId());
            value.setString(4, subs.getSubscriberName());
            value.setString(5, "PENDING");

            value.execute();
            return true;
        } catch (Exception err) {
            System.out.println(err);
            return false;
        }
    }

    public List<Subscription> getAll() {
        String query = "SELECT * FROM subscription";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            ResultSet res = value.executeQuery();

            List<Subscription> subsRes = new ArrayList<>();

            while (res.next()) {
                Subscription subs = new Subscription();

                subs.setCreatorId(res.getInt("creator_id"));
                subs.setSubscriberId(res.getInt("subscriber_id"));
                subs.setStatus(res.getString("status"));
                subs.setCreatorName(res.getString("creator_name"));
                subs.setSubscriberName(res.getString("subscriber_name"));

                subsRes.add(subs);
            }

            return subsRes;
        } catch (Exception err) {
            throw new RuntimeException("Error : " + err.getMessage());
        }
    }

    public List<Subscription> getByStatus(String Status) {
        String query = "SELECT * FROM subscription WHERE status = ?";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            value.setString(1, Status);
            ResultSet res = value.executeQuery();

            List<Subscription> subsRes = new ArrayList<>();

            while (res.next()) {
                Subscription subs = new Subscription();

                subs.setCreatorId(res.getInt("creator_id"));
                subs.setSubscriberId(res.getInt("subscriber_id"));
                subs.setStatus(res.getString("status"));
                subs.setCreatorName(res.getString("creator_name"));
                subs.setSubscriberName(res.getString("subscriber_name"));

                subsRes.add(subs);
            }

            return subsRes;
        } catch (Exception err) {
            throw new RuntimeException("Error : " + err.getMessage());
        }
    }

    public Subscription getByCreatorAndSubscirber(int creator_id, int subscriber_id) {
        String query = "SELECT * FROM subscription WHERE creator_id = ? AND subscriber_id = ?";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            value.setInt(1, creator_id);
            value.setInt(2, subscriber_id);
            ResultSet res = value.executeQuery();

            Subscription subs = new Subscription();
            while (res.next()) {

                subs.setCreatorId(res.getInt("creator_id"));
                subs.setSubscriberId(res.getInt("subscriber_id"));
                subs.setStatus(res.getString("status"));
                subs.setCreatorName(res.getString("creator_name"));
                subs.setSubscriberName(res.getString("subscriber_name"));
            }

            return subs;
        } catch (Exception err) {
            throw new RuntimeException("Error : " + err.getMessage());
        }
    }

    public void updateStatus(Subscription subs) {
        String query = "UPDATE subscription SET status = ? WHERE creator_id = ? AND subscriber_id = ?";

        try {
            Database db = new Database();
            Connection conn = db.getConnection();

            PreparedStatement value = conn.prepareStatement(query);
            value.setInt(2, subs.getCreatorId());
            value.setInt(3, subs.getSubscriberId());
            value.setString(1, subs.getStatus());

            value.execute();
        } catch (Exception err) {
            throw new RuntimeException("Error : " + err.getMessage());
        }
    }
}
