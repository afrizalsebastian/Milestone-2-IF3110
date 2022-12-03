package binotifysubs.services.model;

import java.sql.Timestamp;

public class Logging {
    private String description;
    private String endpoint;
    private String ip;
    private Timestamp request_at;

    // Setter
    public void setDescription(String description) {
        this.description = description;
    }

    public void setEndpoint(String endpoint) {
        this.endpoint = endpoint;
    }

    public void setIp(String ip) {
        this.ip = ip;
    }

    public void setRequestAt(Timestamp request_at) {
        this.request_at = request_at;
    }

    // Getter

    public String getDescription() {
        return this.description;
    }

    public String getEndpoint() {
        return this.endpoint;
    }

    public String getIp() {
        return this.ip;
    }

    public Timestamp getRequestAt() {
        return this.request_at;
    }
}
