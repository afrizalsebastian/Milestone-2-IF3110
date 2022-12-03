package binotifysubs.services;

import javax.xml.ws.Endpoint;

import binotifysubs.services.service.HelloWorld;
import binotifysubs.services.service.SubscriptionServiceImp;

public class App {

    public static void main(String[] args) {
        Endpoint.publish("http://localhost:8080/api/Hello", new HelloWorld());
        Endpoint.publish("http://localhost:8080/api/SubscriptionService", new SubscriptionServiceImp());
    }
}
