import java.io.IOException;
import java.io.OutputStream;
import java.io.PrintStream;

/**
 * Takes a Facebook ID and a plaintext message and prints out the encrypted
 * message
 * 
 * @author John
 * 
 */

public class IBEencrypt {
	public static void main(String[] args) {

		// get FRIEND'S facebook ID
		String facebookID = args[0];
		String msg = "";
		// get the plaintext message
		for (int i = 1; i < args.length; i++) {
			msg += args[i] + " ";
		}
		msg = msg.substring(0, msg.length() - 1);
		// System.out.println()

		// Turn off print statements (turn off the System.out output stream)
		PrintStream out = System.out;
		System.setOut(new PrintStream(new OutputStream() {
			@Override
			public void write(int b) throws IOException {
			}
		}));
		String encMsg = "weak";
		try {
			// encrypt the message with the friend's Facebook ID
			IBE ibe = new IBE();
			String pub = ibe.getPubStr(facebookID);
			encMsg = ibe.getEncFromPub(msg, pub);

		} finally {
			System.setOut(out);
		}
		System.out.println(encMsg);
	}
}
