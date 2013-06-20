import java.io.File;
import java.security.PublicKey;
import java.util.Scanner;

import com.restfb.DefaultFacebookClient;
import com.restfb.FacebookClient;
import com.restfb.Parameter;
import com.restfb.types.FacebookType;
import com.restfb.types.User;

/**
 * Used to send a hidden message to a Facebook friend
 * 
 * @author John
 * 
 */
public class Messenger {
	public static void main(String[] args) throws Exception {
		Messenger m = new Messenger();

		// get the Facebook friend we're sending the message to
		// System.out
		// .println("Who do you want to message (what's their facebook page)?");
		// Scanner console = new Scanner(System.in);
		// String webAddr = console.nextLine();
		String webAddr = args[0];
		String userID = m.getUsername(webAddr);
		// System.out.println(userID);

		// Now get their websites

		// this is a test Access token - need to get real access token on a per
		// user basis (after they add the Facebook app)
		// final String ACCESS_TOKEN =
		// "AAAB3xIlFqK0BAKYs8FNAMka1FKj2GY4J0mQajf2L4mt2WcnLgMRZCEAmyBkIBBMS3BzaIa5h0zJluZBLI22GuvcgOdwFjI8JmzZACIuygZDZD";
		// final String ACCESS_TOKEN =
		// "AAAB3xIlFqK0BAAq46ahHMSrwkQJsPGyf7XjZArLWU12lpUbEbUTFD7UPE07WnHtg0W1AvJpzHXtzwwDqwX6YUouh3c5BU0dSMwXpztyNEB06YDi43";
		String ACCESS_TOKEN = "";
		// try {
		// Scanner filereader = new Scanner(new File("token.txt"));
		// ACCESS_TOKEN = filereader.nextLine();
		ACCESS_TOKEN = args[1];
		// ACCESS_TOKEN =
		// "AAAB3xIlFqK0BAKYs8FNAMka1FKj2GY4J0mQajf2L4mt2WcnLgMRZCEAmyBkIBBMS3BzaIa5h0zJluZBLI22GuvcgOdwFjI8JmzZACIuygZDZD";

		// filereader.close();

		FacebookClient facebookClient = new DefaultFacebookClient(ACCESS_TOKEN);
		User user = facebookClient.fetchObject(userID, User.class);
		PublicKey pub = m.getPublicKey(user, facebookClient);
		// now get the message
		// System.out.println("What message do you want to send?");
		// String message = console.nextLine();
		String message = "";
		for (int i = 2; i < args.length; i++) {
			message += args[i] + " ";
		}
		// now encrypt it
		AsymmetricCipherTest crypt = new AsymmetricCipherTest();
		byte[] encMsg = crypt.encrypt(message.getBytes(), pub, "RSA");
		// now convert it to a list of ints
		String ints = "";
		for (int i = 0; i < encMsg.length; ++i) {
			ints += encMsg[i] + ",";
		}

		// now post that stuff to Facebook
		// FacebookType publishMessageResponse = facebookClient
		// .publish(
		// "me/feed",
		// FacebookType.class,
		// Parameter.with(
		// "message",
		// user.getName()
		// + " here's a secret message for you, use Cryptobook to read it "
		// + "\n\n" + ints));

		System.out.println(ints);
		// + publishMessageResponse.getId());
		// Decrypter.main(new String[] { ints });

		// } catch (com.restfb.exception.FacebookOAuthException e) {
		// System.out.println("Please re-connect your Facebook to Cryptobook");
		// }

	}

	public PublicKey getPublicKey(User user, FacebookClient facebookClient)
			throws Exception {

		String sites[] = user.getWebsite().split("\n");
		String pubInts = "";
		// find the relevant website
		for (int i = 0; i < sites.length; i++) {
//			System.out.println(sites[i]);
			URLshortener u = new URLshortener();
			String expand = u.getLongUrl(sites[i]);
			pubInts = u.getLongUrl(sites[i]);
			if (expand.startsWith("http://www.crypto-book.com/key?val=")) {
				pubInts = expand;
				break;
			}

		}
		// Goo.gl encodes commas as %2C so undo that
		pubInts = pubInts.replace("%2C", ",");
//		System.out.println(pubInts);
		if (pubInts.length() == 0) {
			System.out
					.println("Friend has not added the website to their profile yet");
			System.exit(0);
		}
		pubInts = pubInts.replace("http://www.crypto-book.com/key?val=", "");
		KeyGenerator kg = new KeyGenerator();
		PublicKey pub = (PublicKey) kg.keyFromString(pubInts, true);
		return pub;
	}

	public String getUsername(String webAddr) {
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
		return userID;
	}
}
