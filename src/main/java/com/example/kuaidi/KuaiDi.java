package com.example.kuaidi;

import com.example.MessageUtils;
import com.google.gson.*;
import org.apache.commons.io.FileUtils;
import org.apache.commons.io.IOUtils;
import org.junit.Test;

import java.io.File;
import java.io.InputStream;
import java.net.URL;
import java.net.URLConnection;
import java.util.HashMap;
import java.util.Map;

/**
 * 根据快递单号查询快递信息
 */
public class KuaiDi {

    /**
     * 根据快递单号查询快递信息
     *
     * @param comNum
     * @return
     * @throws Exception
     */
    public String queryKuaiDi(String comNum) throws Exception {
        String returnStr = "";
        URL url = new URL("http://www.kuaidi100.com/autonumber/autoComNum?text=" + comNum);
        URLConnection connection = url.openConnection();
        InputStream inputStream = connection.getInputStream();
        comNum = IOUtils.toString(inputStream, "UTF-8");
        inputStream.close();
        Gson gson = new GsonBuilder().create();
        JsonObject jsonObject = gson.fromJson(comNum, JsonObject.class);
        String num = jsonObject.get("num").getAsString();
        JsonArray jsonArray = jsonObject.getAsJsonArray("auto");
        String comCode = jsonArray.get(0).getAsJsonObject().get("comCode").getAsString();
        url = new URL("http://www.kuaidi100.com/query?type=" + comCode + "&postid=" + num);
        connection = url.openConnection();
        inputStream = connection.getInputStream();
        String str = IOUtils.toString(inputStream, "UTF-8");
        inputStream.close();
        gson = new GsonBuilder().create();
        jsonObject = gson.fromJson(str, JsonObject.class);
        String message = jsonObject.get("message").getAsString();
        if ("ok".equalsIgnoreCase(message)) {
            String com = getCompany(comCode);
            JsonArray data = jsonObject.getAsJsonArray("data");
            StringBuffer buffer = new StringBuffer("单号：" + num + "，" + com + "快递，详情如下：\n");
            for (JsonElement jsonElement : data) {
                jsonObject = jsonElement.getAsJsonObject();
                String time = jsonObject.get("time").getAsString();
                String context = jsonObject.get("context").getAsString();
                String msg = time + " " + context + "\n";
                buffer.append(msg);
            }
            String msg = buffer.toString();
            returnStr = msg.substring(0, msg.lastIndexOf("\n"));
        } else {
            returnStr = message;
        }
        return returnStr;
    }

    /**
     * 查询快递公司
     *
     * @param comCode
     * @return
     * @throws Exception
     */
    public String getCompany(String comCode) throws Exception {
        String jsonCompany = FileUtils.readFileToString(new File("src/main/resources/company.json"), "UTF-8");
        Gson gson = new GsonBuilder().create();
        JsonArray jsonArray = gson.fromJson(jsonCompany, JsonArray.class);
        Map<String, String> companyMap = new HashMap<>();
        for (JsonElement jsonElement : jsonArray) {
            JsonObject jsonObject = jsonElement.getAsJsonObject();
            String key = jsonObject.get("number").getAsString();
            String value = jsonObject.get("name").getAsString();
            companyMap.put(key, value);
        }
        return companyMap.get(comCode);
    }


    @Test
    public void kuaidi() throws Exception {
        String comNum = "9890240094396";
        String msg = queryKuaiDi(comNum);
        System.out.println(msg);
        MessageUtils.sendMessage(msg);
        MessageUtils.sendGroupMessage(msg);
    }

}
