package com.example;

import org.apache.commons.io.IOUtils;

import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;

/**
 * 消息发送类
 */
public class MessageUtils {

    /**
     * 发送个人消息
     *
     * @param msg
     * @return
     * @throws Exception
     */
    public static String sendMessage(String msg) throws Exception {
        return send(msg, "localhost", "171683963", "message");
    }

    /**
     * 发送群消息
     *
     * @param msg
     * @return
     * @throws Exception
     */
    public static String sendGroupMessage(String msg) throws Exception {
        return send(msg, "localhost", "308578890", "group_message");
    }

    /**
     * 发送消息
     *
     * @param msg    消息内容
     * @param server 服务器ip
     * @param qq     QQ号码
     * @param type   个人消息/群消息
     * @return
     * @throws Exception
     */
    public static String send(String msg, String server, String qq, String type) throws Exception {
        msg = URLEncoder.encode(msg, "UTF-8");
        String urlString = "";
        // 个人消息
        if ("message".equalsIgnoreCase(type)) {
            urlString = "http://" + server + ":5000/openqq/send_message?qq=" + qq + "&content=" + msg;
        } else if ("group_message".equalsIgnoreCase(type)) { // 群消息
            urlString = "http://" + server + ":5000/openqq/send_group_message?gnumber=" + qq + "&content=" + msg;
        }
        URL url = new URL(urlString);
        URLConnection connection = url.openConnection();
        String returnStr = IOUtils.toString(connection.getInputStream(), "UTF-8");
        System.out.println(returnStr);
        return returnStr;
    }

}
