TFILE="test.$$.$RANDOM.tmp"
wget -O $TFILE http://www.crypto-book.com/download_msg.php?msg=48,-126,2
zip decrypter.$$.$RANDOM.zip $TFILE Decrypter.jar Decrypt-script.bat
rm $TFILE

