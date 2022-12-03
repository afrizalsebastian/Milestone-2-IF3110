package binotifysubs.services.service;

import binotifysubs.services.model.Logging;
import binotifysubs.services.model.Subscription;
import binotifysubs.services.controller.LogController;
import binotifysubs.services.controller.SubscriptionController;
import io.github.cdimascio.dotenv.Dotenv;

import java.util.List;

import javax.jws.WebService;

import java.util.ArrayList;
import java.sql.Timestamp;

@WebService(endpointInterface = "binotifysubs.services.service.SubscriptionService")
public class SubscriptionServiceImp implements SubscriptionService {

    private SubscriptionController subsController = new SubscriptionController();
    private LogController logController = new LogController();
    Dotenv env = Dotenv.load();
    private String restKey = env.get("REST_KEY");
    private String appKey = "APP";

    @Override
    public boolean insertSubs(int creator_id, int subs_id, String creatorName, String subsName, String status,
            String apiKey) {
        long currentTime = System.currentTimeMillis();
        if (!validateKey(apiKey)) {
            insertLog("UNAUTHORIZED", "IP", "insertSubs", currentTime);
            return false;
        }
        Subscription subs = new Subscription(creator_id, creatorName, subs_id, subsName, status, apiKey);

        boolean result = this.subsController.insertSubs(subs);
        if (!result) {
            insertLog("FAILED : insert new subscription from " + nameRequester(apiKey), "IP", "insertSubs",
                    currentTime);
            return false;
        } else {
            insertLog("SUCCESS : insert new subscription from " + nameRequester(apiKey), "IP", "insertSubs",
                    currentTime);
            return true;
        }
    }

    @Override
    public List<Subscription> getAll(String apiKey) {
        long currentTime = System.currentTimeMillis();
        if (!validateKey(apiKey)) {
            insertLog("UNAUTHORIZED", "IP", "getAll", currentTime);
            return new ArrayList<>();
        }

        insertLog("SUCCESS : get all subscription from " + nameRequester(apiKey), "IP", "getAll", currentTime);
        return this.subsController.getAll();
    }

    @Override
    public List<Subscription> getAllStatusPending(String apiKey) {
        long currentTime = System.currentTimeMillis();
        if (!validateKey(apiKey)) {
            insertLog("UNAUTHORIZED", "IP", "getAllPending", currentTime);
            return new ArrayList<>();
        }

        insertLog("SUCCESS : get all pending subscription from " + nameRequester(apiKey), "IP", "getAllPending",
                currentTime);
        return this.subsController.getByStatus("PENDING");
    }

    @Override
    public boolean acceptSubs(int creator_id, int subs_id, String creatorName, String subsName, String status,
            String apiKey) {
        long currentTime = System.currentTimeMillis();
        if (!validateKey(apiKey)) {
            insertLog("UNAUTHORIZED", "IP", "acceptSubs", currentTime);
            return false;
        }
        Subscription subs = new Subscription(creator_id, creatorName, subs_id, subsName, status, apiKey);

        Subscription temp = this.subsController.getByCreatorAndSubscirber(subs.getCreatorId(), subs.getSubscriberId());
        temp.setStatus("ACCEPTED");
        this.subsController.updateStatus(temp);
        insertLog("SUCCESS : accept subscription from " + nameRequester(apiKey), "IP", "acceptSubs", currentTime);
        return true;
    }

    @Override
    public boolean rejectSubs(int creator_id, int subs_id, String creatorName, String subsName, String status,
            String apiKey) {
        long currentTime = System.currentTimeMillis();
        if (!validateKey(apiKey)) {
            insertLog("UNAUTHORIZED", "IP", "rejectSubs", currentTime);
            return false;
        }

        Subscription subs = new Subscription(creator_id, creatorName, subs_id, subsName, status, apiKey);

        Subscription temp = this.subsController.getByCreatorAndSubscirber(subs.getCreatorId(), subs.getSubscriberId());
        temp.setStatus("REJECTED");
        this.subsController.updateStatus(temp);
        insertLog("SUCCESS : reject subscription from " + nameRequester(apiKey), "IP", "rejectSubs", currentTime);
        return true;
    }

    private boolean validateKey(String Key) {
        return restKey.equals(Key) || appKey.equals(Key);
    }

    private String nameRequester(String Key) {
        if (restKey.equals(Key)) {
            return "REST";
        } else if (appKey.equals(Key)) {
            return "Binotify App";
        }

        return "";
    }

    private void insertLog(String description, String ip, String endpoint, long time) {
        Logging log = new Logging();
        log.setDescription(description);
        log.setIp(ip);
        log.setEndpoint(endpoint);
        log.setRequestAt(new Timestamp(time));

        this.logController.insert(log);
    }
}
