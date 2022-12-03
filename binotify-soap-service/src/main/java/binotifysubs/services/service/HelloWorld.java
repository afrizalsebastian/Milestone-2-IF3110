package binotifysubs.services.service;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.soap.SOAPBinding;
import javax.jws.soap.SOAPBinding.Style;
import binotifysubs.services.model.Test;

@WebService
@SOAPBinding(style = Style.DOCUMENT)
public class HelloWorld {

    @WebMethod
    public String getHello(@WebParam(name = "msg") Test msg) {
        return msg.getMsg();
    }
}
