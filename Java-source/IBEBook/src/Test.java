import it.unisa.dia.gas.jpbc.CurveGenerator;
import it.unisa.dia.gas.jpbc.CurveParameters;
import it.unisa.dia.gas.jpbc.Element;
import it.unisa.dia.gas.jpbc.Field;
import it.unisa.dia.gas.jpbc.Pairing;
import it.unisa.dia.gas.plaf.jpbc.pairing.PairingFactory;
import it.unisa.dia.gas.plaf.jpbc.pairing.a.TypeACurveGenerator;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Scanner;

public class Test {
	public static void main(String[] args) {

		// Init the generator...
		int rBits = 160;
		int qBits = 512;
		CurveGenerator curveGenerator = new TypeACurveGenerator(rBits, qBits);

		// Generate the parameters...
		CurveParameters params = curveGenerator.generate();
		System.out.println(params);

		Pairing pairing = PairingFactory.getPairing(params);
		// pairing must be symmetric
		if (!pairing.isSymmetric()) {
			System.out.println("Pairing must be symmetric");
			System.exit(0);
		}

		// Setup
		Element P = pairing.getG1().newRandomElement();
		Element s = pairing.getZr().newRandomElement();
		// MUST duplicate element before multiplying it
		Element Ppub = P.duplicate();
		Ppub.mulZn(s);

		System.out.println("P: " + P);
		System.out.println("s: " + s);
		System.out.println("Ppub: " + Ppub);
		System.out.println();

		// System.out.println("Enter your Facebook ID:");
		// Scanner console = new Scanner(System.in);
		// Get private key
		// byte[] hash = toSHA1(console.nextLine());
		System.out.println("Extracting public/private keys......");
		byte[] hash = toSHA1("test");
		System.out.print("hash length: ");
		System.out.println(hash.length);
		System.out.println("hash: " + byteToHex(hash));
		System.out.println();

		// public key
		Element Qid = pairing.getG1().newElement()
				.setFromHash(hash, 0, hash.length);

		// multiply to get private key
		Element Sid = Qid.duplicate();
		Sid.mulZn(s);

		// print the stuff out
		System.out.printf("Private key Sid = %s\n", Sid);
		System.out.printf("Public key Qid = %s\n", Qid);
		System.out.println();

		// Encryption:
		System.out.println("Encryption.....");

		String message = "weak";
		System.out.println("Message: " + message);

		System.out.println("Message length: " + message.getBytes().length);

		byte[] fakeShaMsg = new byte[message.length()];
		for (int i = 0; i < message.getBytes().length; i++) {
			fakeShaMsg[i] = message.getBytes()[i];
		}

		byte[] shamessage = toSHA1(message); // Get the message digest

		shamessage = fakeShaMsg;

		System.out.println("Message hash length: " + shamessage.length);
		System.out.println("The message hash: " + byteToHex(shamessage));

		// Choose a random r
		Element r = pairing.getZr().newRandomElement();

		Element U = P.duplicate();
		U.mulZn(r);
		System.out.println("U: " + U);

		Element gid = pairing.pairing(Qid, Ppub);
		gid.powZn(r);
		String sgid = gid.toString();
		byte[] shagid = toSHA1(sgid);

		// need to XOR shamessage an shagid
		byte[] V = new byte[shamessage.length];
		for (int i = 0; i < shamessage.length; i++) {
			V[i] = (byte) (shamessage[i] ^ shagid[i % 20]);
		}

		System.out.println();
		// Decryption:
		System.out.println("Decryption.....");

		Element rgid = pairing.pairing(Sid, U);
		String sgid_receiver = rgid.toString();
		byte[] shagid_receiver = toSHA1(sgid_receiver);

		// Decrypted message
		byte[] M = new byte[V.length];

		for (int i = 0; i < V.length; i++) {
			M[i] = (byte) (V[i] ^ shagid_receiver[i % 20]);
		}

		String test = new String(M);
		System.out.println("test: " + test);

		System.out.println("M-in:" + byteToHex(shamessage));
		System.out.println("Mout: " + byteToHex(M));

		if (byteToHex(M).equals(byteToHex(shamessage))) {
			System.out.println("IT WORKED!!!!");
		}

		System.out.println("ENDED");
	}

	// do the hashing
	public static byte[] toSHA1(String convertme) {
		MessageDigest md = null;
		try {
			md = MessageDigest.getInstance("SHA-1");
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		}
		return md.digest(convertme.getBytes());
	}

	// convert hash to hex to display
	public static String byteToHex(byte[] b) {
		String result = "";
		for (int i = 0; i < b.length; i++) {
			result += Integer.toString((b[i] & 0xff) + 0x100, 16).substring(1);
		}
		return result;
	}
}
