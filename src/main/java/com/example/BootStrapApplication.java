package com.example;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import org.apache.commons.io.IOUtils;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import javax.servlet.ServletInputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@SpringBootApplication
@RestController
public class BootStrapApplication {

    @RequestMapping(value = "/", method = RequestMethod.POST, produces = "application/json; charset=UTF-8")
    public String hello(HttpServletRequest request, HttpServletResponse response) throws Exception {
        ServletInputStream inputStream = request.getInputStream();
        String msg = IOUtils.toString(inputStream, "UTF-8");
        inputStream.close();
        Gson gson = new GsonBuilder().create();
        Message message = gson.fromJson(msg, Message.class);
        // 群消息
        if ("group_message".equalsIgnoreCase(message.getType())) {
            String content = message.getContent();
            msg = MessageUtils.sendGroupMessage("");
        } else if ("message".equalsIgnoreCase(message.getType())) { // 个人消息
            msg = MessageUtils.sendMessage("");
        }
        return msg;
    }

    public static void main(String[] args) {
        SpringApplication.run(BootStrapApplication.class, args);
    }
}
