import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.security.PrivateKey;
import java.util.Scanner;

import javax.swing.JOptionPane;

public class Decrypter {
	static final int MAX_LINES = 10;

	public static void main(String[] args) throws Exception {
		System.out.println("Decrypting....");
		String ints = "";
		if (args.length > 0) {
			// System.out.println(args[0]);
			BufferedReader br = null;
			String input = "";
			try {
				String sCurrentLine;
				br = new BufferedReader(new FileReader(args[0]));
				while ((sCurrentLine = br.readLine()) != null) {
					input += sCurrentLine;
				}
			} catch (IOException e) {
				e.printStackTrace();
			}
			// System.out.println(input);
			ints = input;
		} else {

			// get the Facebook message
			System.out.println("What message do you want to decrypt?");
			Scanner console = new Scanner(System.in);
			ints = console.nextLine();
			// String ints = args[0];
		}

		AsymmetricCipherTest decoder = new AsymmetricCipherTest();
		// System.out.println("Where is you private key (filename)?");
		// String filename = console.nextLine();
		String filename = "mysecret.txt";
		// make sure the user added the right suffix
		if (!filename.contains("-priv.txt") && !filename.contains(".txt")) {
			filename += "-priv.txt";
		}
		if (!filename.contains(".txt")) {
			filename += ".txt";
		}
		// get the private key
		KeyGenerator kg = new KeyGenerator();
		PrivateKey priv = (PrivateKey) kg.readKey(filename, false);
		// decode that message
		String s = new String(decoder.decrypt(kg.bytesFromInts(ints), priv,
				"RSA"));
		// System.out.println("Message:");
		// System.out.println();
		JOptionPane.showMessageDialog(null, s);

		// delete the temporary msg file
		try {
			File file = new File(args[0]);
			if (file.delete()) {
				// System.out.println(file.getName() + " is deleted!");
			} else {
				// System.out.println("Delete operation is failed.");
			}
		} catch (Exception e) {

			e.printStackTrace();

		}
		// System.out.println(s);
		// System.out.println();
		// Scanner console = new Scanner(System.in);
		// ints = console.nextLine();

	}
}
