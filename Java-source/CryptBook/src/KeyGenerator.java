import java.io.BufferedReader;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.security.Key;
import java.security.KeyFactory;
import java.security.KeyPair;
import java.security.KeyPairGenerator;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.SecureRandom;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;

public class KeyGenerator {
	// The public private key pair
	PublicKey pub;
	PrivateKey priv;

	public static void main(String[] args) throws Exception {
	
		// create key pair
		KeyGenerator kg = new KeyGenerator();
		// save the public key
		kg.saveKey("suepk.txt", kg.pub);
		kg.saveKey("private.txt", kg.priv);

		// read public key from file
		PublicKey mypub = (PublicKey) kg.readKey("suepk.txt", true);
		// System.out.println(mypub);
		PrivateKey mypriv = (PrivateKey) kg.readKey("private.txt", false);

		// encrypt the message
		AsymmetricCipherTest encryptor = new AsymmetricCipherTest();
		String xform = "RSA";
		// message to encrypt
		String message = "Jay man in the house!!!";
		byte[] dataBytes = message.getBytes();
		// encrypt the message
		byte[] encBytes = encryptor.encrypt(dataBytes, mypub, xform);
		// decrypt the message
		byte[] decBytes = encryptor.decrypt(encBytes, mypriv, xform);

		// convert bytes back to string
		String s = new String(decBytes);

		// print out the result
		System.out.println("Decrypted message:");
		System.out.println(s);

	}

	// create a keypair
	public KeyGenerator() throws Exception {
		// Generate a public private keypair using DSA
		KeyPairGenerator keyGen = KeyPairGenerator.getInstance("RSA");
		SecureRandom random = SecureRandom.getInstance("SHA1PRNG", "SUN");
		keyGen.initialize(1024, random);
		KeyPair pair = keyGen.generateKeyPair();
		priv = pair.getPrivate();
		pub = pair.getPublic();
		// System.out.println(priv);
		// System.out.println(pub);
	}

	// save the public (or private) key
	public void saveKey(String filename, Key pub) throws Exception {
		// save the public key in a file
		// get the byte array version of the key
		byte[] key = pub.getEncoded();

		int[] ia = intsFromBytes(key);

		// print the integers to file, comma separated
		PrintWriter out = new PrintWriter(new FileWriter(filename));
		for (int x : ia) {
			out.print(x + ",");
		}
		out.close();
	}

	public int[] intsFromBytes(byte[] key) {
		// convert from byte array to int array
		int[] ia = new int[key.length];
		for (int i = 0; i < key.length; ++i) {
			ia[i] = key[i];
		}
		return ia;
	}

	// read a public key from a file
	public Key readKey(String filename, boolean isPub) throws Exception {
		// read public key from a file
		BufferedReader in = new BufferedReader(new FileReader(filename));
		String ints = in.readLine();
		in.close();
		return keyFromString(ints, isPub);
	}

	public Key keyFromString(String ints, boolean isPub) throws Exception {
		byte[] bytesOut = bytesFromInts(ints);
		// now build the public key back from the byte array
		X509EncodedKeySpec pubKeySpec = new X509EncodedKeySpec(bytesOut);
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");

		if (isPub) {
			PublicKey pubKey = keyFactory.generatePublic(pubKeySpec);
			return pubKey;
		} else {
			PKCS8EncodedKeySpec privKeySpec = new PKCS8EncodedKeySpec(bytesOut);
			PrivateKey privKey = keyFactory.generatePrivate(privKeySpec);
			return privKey;
		}
	}

	public byte[] bytesFromInts(String ints) {
		// now get out all the integers
		String[] inputs = ints.split(",");
		int[] intsIn = new int[inputs.length];
		// put the integers into an int array
		for (int i = 0; i < inputs.length; i++) {
			intsIn[i] = Integer.parseInt(inputs[i]);
			// System.out.print(intsIn[i] + ",");
		}
		// System.out.println();

		// now convert the integers back to bytes
		byte[] bytesOut = new byte[intsIn.length];
		for (int i = 0; i < intsIn.length; ++i) {
			bytesOut[i] = (byte) intsIn[i];
		}
		return bytesOut;
	}
}
