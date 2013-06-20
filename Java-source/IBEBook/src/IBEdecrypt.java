import java.io.IOException;
import java.io.OutputStream;
import java.io.PrintStream;

/**
 * Takes a Facebook ID and an encrypted message and prints out the decrypted
 * message
 * 
 * @author John
 * 
 */

public class IBEdecrypt {
	public static void main(String[] args) {

		// get USER'S OWN facebook ID
		String facebookID = args[0];
		String encMsg = args[1];
		// System.out.println(encMsg);

		// Turn off print statements (turn off the System.out output stream)
		PrintStream out = System.out;
		System.setOut(new PrintStream(new OutputStream() {
			@Override
			public void write(int b) throws IOException {
			}
		}));
		String decMsg = "weak";
		try {
			// encrypt the message with the friend's Facebook ID
			IBE ibe = new IBE();
			String priv = ibe.getPrivStr(facebookID);

			// Have to call this just to initialize some objects, just ignore
			// result
			ibe.getEncFromID("you are weak", "test");

			decMsg = ibe.getDecFromPriv(encMsg, priv);
		} finally {
			System.setOut(out);
		}
		System.out.println(decMsg);
	}
}
