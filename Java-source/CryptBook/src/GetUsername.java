
public class GetUsername {
	public static void main(String [] args) {
		String webAddr = args[0];
		String userID = "";
		// get that user ID if they don't have a Facebook username
		if (webAddr.contains("id=")) {
			// strip out the username
			String[] strs = webAddr.split("id=");
			String s = strs[1];
			for (int i = 0; i < s.length(); i++) {
				char c = s.charAt(i);
				if (!Character.isDigit(c)) {
					break;
				}
				userID += c;
			}
		} else {
			// get Facebook username
			String strs[] = webAddr.split("facebook.com/");
			String s = strs[1];
			for (int i = 0; i < s.length(); i++) {
				char c = s.charAt(i);
				if (c == '?' || c == '/') {
					break;
				}
				userID += c;
			}
		}
		System.out.println(userID);
	}
}
