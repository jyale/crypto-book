import java.io.IOException;
import java.io.OutputStream;
import java.io.PrintStream;

public class GetPriv {
	public static void main(String[] args) {
		String facebookID = args[0];

		// Turn off print statements (turn off the System.out output stream)
		PrintStream out = System.out;
		System.setOut(new PrintStream(new OutputStream() {
			@Override
			public void write(int b) throws IOException {
			}
		}));
		String priv = "weak";
		try {
			IBE ibe = new IBE();
			priv = ibe.getPrivStr(facebookID);
		} finally {
			System.setOut(out);
		}
		System.out.println(priv);
	}
}
