import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.net.URL;
import java.net.URLConnection;
import java.util.Scanner;

import com.google.gson.Gson;

public class Google {
	private static final String URL_GOOGL_SERVICE = "https://www.googleapis.com/urlshortener/v1/url";

	private static final Gson gson = new Gson();
	
	public static void main(String[] args){
		System.out.println(shorten("google.com"));
	}

	public static String shorten(String longUrl) {
		String result = new String();
		GsonGooGl gsonGooGl = new GsonGooGl(longUrl);

		try {
			URL url = new URL(URL_GOOGL_SERVICE);

			URLConnection urlConn = url.openConnection();
			urlConn.setDoInput(true); // Let the run-time system (RTS) know that
										// we want input.
			urlConn.setDoOutput(true); // Let the RTS know that we want to do
										// output.
			urlConn.setUseCaches(false); // No caching, we want the real thing.
			urlConn.setRequestProperty("Content-Type", "application/json"); // Specify
																			// the
																			// content
																			// type.

			DataOutputStream printout = new DataOutputStream(
					urlConn.getOutputStream()); // Send POST output.
			String content = gson.toJson(gsonGooGl);
			printout.writeBytes(content);
			printout.flush();
			printout.close();

			DataInputStream input = new DataInputStream(
					urlConn.getInputStream()); // Get response data.

			Scanner sc = new Scanner(input);
			while (sc.hasNext()) {
				result += sc.next();
			}

			GooGlResult gooGlResult = gson.fromJson(result, GooGlResult.class);

			return gooGlResult.getId();
		} catch (Exception ex) {
			System.out.println(ex);
			return null;
		}
	}
}

class GsonGooGl {
	public GsonGooGl() {
	}

	public GsonGooGl(String longUrl) {
		this.longUrl = longUrl;
	}

	private String longUrl;

	public String getLongUrl() {
		return longUrl;
	}

	public void setLongUrl(String longUrl) {
		this.longUrl = longUrl;
	}

}

class GooGlResult {
	public GooGlResult() {
	}

	private String kind;
	private String id;
	private String longUrl;

	public String getKind() {
		return kind;
	}

	public void setKind(String kind) {
		this.kind = kind;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getLongUrl() {
		return longUrl;
	}

	public void setLongUrl(String longUrl) {
		this.longUrl = longUrl;
	}

}