package binotifysubs.services.service;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import java.util.List;

import binotifysubs.services.model.Subscription;

@WebService
@SOAPBinding(style = Style.DOCUMENT)
public interface SubscriptionService {

        @WebMethod
        boolean insertSubs(
                        @WebParam(name = "creatorId") int crator_id, @WebParam(name = "subsId") int subs_id,
                        @WebParam(name = "creatorName") String creatorName,
                        @WebParam(name = "subsName") String subsName,
                        @WebParam(name = "status") String status, @WebParam(name = "apiKey") String apiKey);

        @WebMethod
        List<Subscription> getAll(
                        @WebParam(name = "api") String apiKey);

        @WebMethod
        List<Subscription> getAllStatusPending(
                        @WebParam(name = "api") String apiKey);

        @WebMethod
        boolean acceptSubs(
                        @WebParam(name = "creatorId") int crator_id, @WebParam(name = "subsId") int subs_id,
                        @WebParam(name = "creatorName") String creatorName,
                        @WebParam(name = "subsName") String subsName,
                        @WebParam(name = "status") String status, @WebParam(name = "apiKey") String apiKey);

        @WebMethod
        boolean rejectSubs(
                        @WebParam(name = "creatorId") int crator_id, @WebParam(name = "subsId") int subs_id,
                        @WebParam(name = "creatorName") String creatorName,
                        @WebParam(name = "subsName") String subsName,
                        @WebParam(name = "status") String status, @WebParam(name = "apiKey") String apiKey);

}
