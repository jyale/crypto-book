import java.security.KeyPairGenerator;
import java.security.KeyPair;
import java.security.PublicKey;
import java.security.PrivateKey;
import javax.crypto.Cipher;

public class AsymmetricCipherTest {
	public byte[] encrypt(byte[] inpBytes, PublicKey key, String xform)
			throws Exception {
		Cipher cipher = Cipher.getInstance(xform);
		cipher.init(Cipher.ENCRYPT_MODE, key);
		return cipher.doFinal(inpBytes);
	}

	public byte[] decrypt(byte[] inpBytes, PrivateKey key, String xform)
			throws Exception {
		Cipher cipher = Cipher.getInstance(xform);
		cipher.init(Cipher.DECRYPT_MODE, key);
		return cipher.doFinal(inpBytes);
	}

	public static void main(String[] unused) throws Exception {
		AsymmetricCipherTest encryptor = new AsymmetricCipherTest();
		
		
		String xform = "RSA";
		// Generate a key-pair
		KeyPairGenerator kpg = KeyPairGenerator.getInstance("RSA");
		kpg.initialize(512); // 512 is the keysize.
		KeyPair kp = kpg.generateKeyPair();
		PublicKey pubk = kp.getPublic();
		PrivateKey prvk = kp.getPrivate();

		byte[] dataBytes = "J2EE Security for Servlets, EJBs and Web Services"
				.getBytes();

		byte[] encBytes = encryptor.encrypt(dataBytes, pubk, xform);
		byte[] decBytes = encryptor.decrypt(encBytes, prvk, xform);
		String s = new String(decBytes);
		System.out.println(s);

		boolean expected = java.util.Arrays.equals(dataBytes, decBytes);
		System.out.println("Test " + (expected ? "SUCCEEDED!" : "FAILED!"));
	}
}