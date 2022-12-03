package binotifysubs.services.model;

public class Subscription {
    private int creator_id;
    private String creator_name;
    private int subscriber_id;
    private String subscriber_name;
    private String status;
    private String apiKey;

    public Subscription() {
        this.creator_id = 0;
        this.subscriber_id = 0;
        this.creator_name = "";
        this.subscriber_name = "";
        this.status = "";
    }

    public Subscription(int creator_id, String creator_name, int subscriber_id, String subscriber_name, String status,
            String apiKey) {
        this.creator_id = creator_id;
        this.subscriber_id = subscriber_id;
        this.creator_name = creator_name;
        this.subscriber_name = subscriber_name;
        this.status = status;
        this.apiKey = apiKey;
    }

    // Getter
    public int getCreatorId() {
        return this.creator_id;
    }

    public int getSubscriberId() {
        return this.subscriber_id;
    }

    public String getCreatorName() {
        return this.creator_name;
    }

    public String getSubscriberName() {
        return this.subscriber_name;
    }

    public String getStatus() {
        return this.status;
    }

    public String getApiKey() {
        return this.apiKey;
    }

    // Setter
    public void setCreatorId(int creator_id) {
        this.creator_id = creator_id;
    }

    public void setSubscriberId(int subscriber_id) {
        this.subscriber_id = subscriber_id;
    }

    public void setCreatorName(String creatorName) {
        this.creator_name = creatorName;
    }

    public void setSubscriberName(String subscriberName) {
        this.subscriber_name = subscriberName;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    private void setApiKey(String apiKey) {
        this.apiKey = apiKey;
    }
}
