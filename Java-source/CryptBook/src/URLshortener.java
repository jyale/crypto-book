import java.io.*;
import java.net.*;

public class URLshortener {

	private String getHTML(String urlToRead) throws Exception {
		URL url;
		HttpURLConnection conn;
		BufferedReader rd;
		String line;
		String result = "";

		url = new URL(urlToRead);
		conn = (HttpURLConnection) url.openConnection();
		conn.setRequestMethod("GET");
		rd = new BufferedReader(new InputStreamReader(conn.getInputStream()));
		while ((line = rd.readLine()) != null) {
			result += line;
		}
		rd.close();

		return result;
	}

	public String getLongUrl(String shortUrl) {
		URLshortener c = new URLshortener();
		final String KEY = "AIzaSyCUqhbgZ2bsRkOWD8K7qmwHl0dsFGQ4Cek";
		final String GOOG_URL = "https://www.googleapis.com/urlshortener/v1/url?key="
				+ KEY + "&shortUrl=";
		try {
			String output = c.getHTML(GOOG_URL + shortUrl);

			String[] strs = output.split("longUrl\": \"");
			output = strs[1];
			strs = output.split("\", \"status\"");
			output = strs[0];
			return output;
		} catch (Exception e) {
			return "weak";
		}
	}

	public static void main(String args[]) {
		URLshortener c = new URLshortener();
		String shortUrl = "http://goo.gl/2w9yw";
		System.out.println(c.getLongUrl(shortUrl));

	}
}