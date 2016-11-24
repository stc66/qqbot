package com.example;

import java.io.Serializable;

/**
 * 封装消息实体
 */
public class Message implements Serializable {

    /**
     * 消息内容
     */
    private String content;
    /**
     * 群号
     */
    private String gnumber;
    /**
     * 群名称
     */
    private String group;
    /**
     * 群id
     */
    private String group_id;
    /**
     * msg_class
     */
    private String msg_class;
    /**
     * 消息id
     */
    private String msg_id;
    /**
     * 消息时间
     */
    private String msg_time;
    /**
     * 消息接收者昵称
     */
    private String receiver;
    /**
     * 消息接收者id(就是接收者QQ号)
     */
    private String receiver_id;
    /**
     * 消息接收者QQ
     */
    private String receiver_qq;
    /**
     * 消息发送者昵称
     */
    private String sender;
    /**
     * 消息发送者id
     */
    private String sender_id;
    /**
     * 消息发送者QQ
     */
    private String sender_qq;
    /**
     * 消息类型group_message(群消息)/message(个人消息)
     */
    private String type;

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getGnumber() {
        return gnumber;
    }

    public void setGnumber(String gnumber) {
        this.gnumber = gnumber;
    }

    public String getGroup() {
        return group;
    }

    public void setGroup(String group) {
        this.group = group;
    }

    public String getGroup_id() {
        return group_id;
    }

    public void setGroup_id(String group_id) {
        this.group_id = group_id;
    }

    public String getMsg_class() {
        return msg_class;
    }

    public void setMsg_class(String msg_class) {
        this.msg_class = msg_class;
    }

    public String getMsg_id() {
        return msg_id;
    }

    public void setMsg_id(String msg_id) {
        this.msg_id = msg_id;
    }

    public String getMsg_time() {
        return msg_time;
    }

    public void setMsg_time(String msg_time) {
        this.msg_time = msg_time;
    }

    public String getReceiver() {
        return receiver;
    }

    public void setReceiver(String receiver) {
        this.receiver = receiver;
    }

    public String getReceiver_id() {
        return receiver_id;
    }

    public void setReceiver_id(String receiver_id) {
        this.receiver_id = receiver_id;
    }

    public String getReceiver_qq() {
        return receiver_qq;
    }

    public void setReceiver_qq(String receiver_qq) {
        this.receiver_qq = receiver_qq;
    }

    public String getSender() {
        return sender;
    }

    public void setSender(String sender) {
        this.sender = sender;
    }

    public String getSender_id() {
        return sender_id;
    }

    public void setSender_id(String sender_id) {
        this.sender_id = sender_id;
    }

    public String getSender_qq() {
        return sender_qq;
    }

    public void setSender_qq(String sender_qq) {
        this.sender_qq = sender_qq;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }
}
