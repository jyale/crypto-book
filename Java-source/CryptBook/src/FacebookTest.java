import com.restfb.DefaultFacebookClient;
import com.restfb.FacebookClient;
import com.restfb.Parameter;
import com.restfb.types.FacebookType;
import com.restfb.types.Page;
import com.restfb.types.User;

public class FacebookTest {
	public static void main(String[] args) {
		final String ACCESS_TOKEN = "AAAB3xIlFqK0BAKYs8FNAMka1FKj2GY4J0mQajf2L4mt2WcnLgMRZCEAmyBkIBBMS3BzaIa5h0zJluZBLI22GuvcgOdwFjI8JmzZACIuygZDZD";
		// final String andrew = "100005332951012";

		// where your friend's profile at?
		String friendUsername = "http://www.facebook.com/profile.php?id=100005332951012&someshizzzzzle";
		String userID = "";
		// get that user ID
		if (friendUsername.contains("id=")) {
			// strip out the username
			String[] strs = friendUsername.split("id=");
			String s = strs[1];
			for (int i = 0; i < s.length(); i++) {
				char c = s.charAt(i);
				if (!Character.isDigit(c)) {
					break;
				}
				userID += c;
			}
			System.out.println(userID);
		}

		FacebookClient facebookClient = new DefaultFacebookClient(ACCESS_TOKEN);
		User user = facebookClient.fetchObject("me", User.class);
		Page page = facebookClient.fetchObject("cocacola", Page.class);

		System.out.println("User name: " + user.getName());
		System.out.println("Page likes: " + page.getLikes());
		System.out.println(user.getWebsite());

		// publish some stuff
		FacebookType publishMessageResponse = facebookClient.publish("me/feed",
				FacebookType.class, Parameter.with("message", "test stuff"));

		System.out.println("Published message ID: "
				+ publishMessageResponse.getId());

	}
}
