import it.unisa.dia.gas.jpbc.CurveGenerator;
import it.unisa.dia.gas.jpbc.CurveParameters;
import it.unisa.dia.gas.jpbc.Element;
import it.unisa.dia.gas.jpbc.Pairing;
import it.unisa.dia.gas.plaf.jpbc.pairing.PairingFactory;
import it.unisa.dia.gas.plaf.jpbc.pairing.a.TypeACurveGenerator;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Scanner;

import javax.xml.bind.DatatypeConverter;

public class IBE {
	Pairing pairing;
	Element P;
	Element s;
	Element Ppub;
	Element U;
	byte[] V;

	public IBE() {
		setup();
	}

	private void setup() {
		// Init the generator...
		int rBits = 160;
		int qBits = 512;
		CurveGenerator curveGenerator = new TypeACurveGenerator(rBits, qBits);

		// Generate the parameters...
		CurveParameters params = curveGenerator.generate();

		// Saving curve parameters is not really necessary since P, s, Ppub are
		// not determistically picked from curve params, so have to save P and s
		// separately
		File f = new File("curve.properties.txt");
		if (f.exists()) {
			// load the parameters
			params = PairingFactory.getInstance().loadCurveParameters(
					"curve.properties.txt");
		} else {
			// generate new parameters
			try {
				PrintWriter out = new PrintWriter(f);
				out.print(params);
				out.close();
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

		pairing = PairingFactory.getPairing(params);

		// System.out.println(params);

		// pairing must be symmetric
		if (!pairing.isSymmetric()) {
			System.out.println("Pairing must be symmetric");
			System.exit(0);
		}

		// Setup
		P = pairing.getG1().newRandomElement();
		s = pairing.getZr().newRandomElement();

		// Save IBE parameters to file
		File pbyte = new File("Pbyte.txt");
		File sbyte = new File("sbyte.txt");
		try {
			// if the parameters have already been set, read them from the file
			if (pbyte.exists() && sbyte.exists()) {

				// read files
				Scanner in = new Scanner(pbyte);
				String pinstr = in.nextLine();
				byte[] PbyteIn = this.toByteArray(pinstr);
				// System.out.println(Pstr);
				P.setFromBytes(PbyteIn);
				in.close();
				in = new Scanner(sbyte);
				String sinstr = in.nextLine();
				byte[] SbyteIn = this.toByteArray(sinstr);
				s.setFromBytes(SbyteIn);
				in.close();

			} else {
				// save them to file
				byte[] Pbyte = P.toBytes();
				byte[] Sbyte = s.toBytes();
				String Pstr = this.toHexString(Pbyte);
				String Sstr = this.toHexString(Sbyte);

				// save to files
				PrintWriter out = new PrintWriter(pbyte);
				out.println(Pstr);
				out.close();
				out = new PrintWriter(sbyte);
				out.println(Sstr);
				out.close();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}

		// MUST duplicate element before multiplying it
		// Ppub depends solely on P and s so do not need to save Ppub
		Ppub = P.duplicate();
		Ppub.mulZn(s);

		System.out.println("P: " + P);
		System.out.println("s: " + s);
		System.out.println("Ppub: " + Ppub);
		System.out.println();
	}

	private Element extractPublic(String in) {
		// System.out.println("Enter your Facebook ID:");
		// Scanner console = new Scanner(System.in);
		// Get private key
		// byte[] hash = toSHA1(console.nextLine());
		System.out.println("Extracting public key......");
		byte[] hash = toSHA1(in);

		// public key
		Element Qid = pairing.getG1().newElement()
				.setFromHash(hash, 0, hash.length);
		System.out.printf("Public key Qid = %s\n", Qid);
		System.out.println();

		return Qid;
	}

	private Element extractPriv(String in) {
		System.out.println("Extracting private key......");
		Element Qid = extractPublic(in);
		// multiply to get private key
		Element Sid = Qid.duplicate();
		Sid.mulZn(s);

		// print the stuff out
		System.out.printf("Private key Sid = %s\n", Sid);
		return Sid;
	}

	private void encrypt(String s, Element Qid) {
		// Encryption:
		System.out.println("Encryption.....");

		String message = s;
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
		this.U = U;
		this.V = V;

	}

	private String decrypt(Element Sid) {
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
		System.out.println("decrypted: " + test);
		return test;

	}

	private String getEncrypted(String s, Element Qid) {
		encrypt(s, Qid);
		// save U and V and send to recipient
		byte[] Ubyte = this.U.toBytes();
		// ibe.U.setFromBytes(Ubyte);
		String Ustr = this.toHexString(Ubyte);
		String Vstr = this.toHexString(this.V);
		System.out.println("U: " + Ustr);
		System.out.println("V: " + Vstr);
		return Ustr + "-" + Vstr;

	}

	private String getDecrypted(String s, Element Sid) {
		String[] strs = s.split("-");
		String U = strs[0];
		String V = strs[1];
		this.U.setFromBytes(toByteArray(U));
		this.V = toByteArray(V);
		return this.decrypt(Sid);
	}

	// get the string representation of a PRIVATE key
	public String getPrivStr(String s) {
		Element priv = extractPriv(s);
		byte[] privbytes = priv.toBytes();
		return this.toHexString(privbytes);
	}

	// get the string representation of a PUBLIC key
	public String getPubStr(String s) {
		Element pub = extractPublic(s);
		byte[] pubbytes = pub.toBytes();
		return this.toHexString(pubbytes);
	}

	public String getEncFromID(String msg, String FacebookID) {
		String s2 = this.getPubStr(FacebookID);
		Element pub = this.pairing.getG1().newElement();
		pub.setFromBytes(this.toByteArray(s2));
		// get encrypted message
		String encMsg = this.getEncrypted(msg, pub);
		return encMsg;
	}

	public String getDecFromID(String msg, String FacebookID) {
		String s1 = this.getPrivStr(FacebookID);
		Element priv = this.pairing.getG1().newElement();
		priv.setFromBytes(this.toByteArray(s1));
		// get encrypted message
		String decMsg = this.getDecrypted(msg, priv);
		return decMsg;
	}

	public String getDecFromPriv(String msg, String privStr) {
		Element priv = this.pairing.getG1().newElement();
		priv.setFromBytes(this.toByteArray(privStr));
		// get encrypted message
		String decMsg = this.getDecrypted(msg, priv);
		return decMsg;
	}

	public String getEncFromPub(String msg, String pubStr) {
		Element pub = this.pairing.getG1().newElement();
		pub.setFromBytes(this.toByteArray(pubStr));
		// get encrypted message
		String encMsg = this.getEncrypted(msg, pub);
		return encMsg;
	}

	public static void main(String[] args) {
		IBE ibe = new IBE();
		String FacebookID = "weakcode";

//		String priv = ibe.getPrivStr(FacebookID);
//		String pub = ibe.getPubStr(FacebookID);

		String encMsg = ibe.getEncFromID("you are weak", FacebookID);
		
		//System.out.println(encMsg);
		 encMsg = "873DBD35C3DB370A72FFBDDED4FD30335A0F046AC05A2563AC1A0851DBF3182D4E0B06800A61EA4927824387D3519FAC752C96180E8EA0C63BBD510CE36996D70963C23B49FB27FD03726E06AED845B6D4B7D50DA718A0D13D616C6872CD2B41E0D6943410A3EBD40CCD333FC73146F94D1657EDA2E828F6EA5357407683435A-2D766CF09C1CDE043375FD04";
		String decMsg = ibe.getDecFromID(encMsg, FacebookID);

		System.out.println("Decoded msg: " + decMsg);

		// set U and V (the encrypted message) to random stuff to test encoding
		// and decoding from hex string
		// ibe.U.setToRandom();
		// ibe.V = null;

		// System.out.println("M-in:" + byteToHex(shamessage));
		// System.out.println("Mout: " + byteToHex(M));
		//
		// if (byteToHex(M).equals(byteToHex(shamessage))) {
		// System.out.println("IT WORKED!!!!");
		// }

		System.out.println("ENDED");
	}

	// convert between byte array and hex string. Used to save public and
	// private keys, and encrypted message
	public String toHexString(byte[] array) {
		return DatatypeConverter.printHexBinary(array);
	}

	public byte[] toByteArray(String s) {
		return DatatypeConverter.parseHexBinary(s);
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
