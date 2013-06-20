import java.io.BufferedReader;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.util.Scanner;

/**
 * This class is used to create the initial keypair and save them. It also tells
 * the user what to put on their facebook profile (a web address) to allow
 * others to sent them messages
 * 
 * @author John
 * 
 */
public class CreateMyKey {
	public static void main(String[] args) throws Exception {
		// use to create keys
		KeyGenerator kg = new KeyGenerator();
		Scanner console = new Scanner(System.in);
		// get the filename for the keys
		// System.out
		// .println("Key name? (used for filenames of pub and priv keys)");
		// String filename = console.nextLine();
		String filename = "mykey";

		// save the keys
		kg.saveKey(filename + "-pub.txt", kg.pub);
		kg.saveKey(filename + "-priv.txt", kg.priv);
		int[] pubints = kg.intsFromBytes(kg.pub.getEncoded());
		int[] privints = kg.intsFromBytes(kg.priv.getEncoded());
		String pubstr = strFromInts(pubints);
		String privstr = strFromInts(privints);
	
		// System.out
		// .println("Add this website to your Facebook profile, make sure its public or at lease visible to your friends");
		// BufferedReader in = new BufferedReader(new FileReader(filename
		// + "-pub.txt"));
		// System.out.println();
		// System.out.println("http://www.crypto-book.com/key?val="
		// + in.readLine());
		// System.out.println();
		// System.out.println("The web address has been saved in:");
		// System.out.println(filename + "-webaddr.txt");
		// get the byte array version of the key
		byte[] key = kg.pub.getEncoded();

		
		int[] ia = kg.intsFromBytes(key);

		// print the integers to file, comma separated
		PrintWriter out = new PrintWriter(new FileWriter(filename
				+ "-webaddr.txt"));
		out.print("http://www.crypto-book.com/key?val=");
		for (int x : ia) {
			out.print(x + ",");
		}
		out.close();

		System.out.print(pubstr);
		System.out.print("X");
		System.out.println(privstr);

	}

	public static String strFromInts(int[] ints) {
		String result = "";
		for (int i = 0; i < ints.length; i++) {
			result += ints[i] + ",";
		}
		return result;
	}
}
