
# GoldRAAS <img src="https://hotemoji.com/images/dl/2/lock-emoji-by-twitter.png" width="40" height="40">
Ransomware with a web panel
## SETUP
In the client change the user ID to whoever it is.
<u>I will make a stub generator when I next update it!</u>
## NOTES
- A lot of the functions are *ahem* stolen from stackoverflow and some other sites (don't have links, may be in comments on code)
- There is no SQL Injection exploits, challenge you to find one.
- There is XSS however I am fully aware of this and know how to fix it.
- The decryption key is generated server side and then given to the client via a GET request. If the client makes the GET request again the server will tell them to piss off basically.
- The decryption key is deleted from the users memeory as soon as the client has encrypted the file(/s) to be safe.
- The encryption is done with AES256 and a random salt to prevent precracking. (EXTREMELY UNLIKELY)
## To Do
- Generate Stub
- Encrypt whole system (rather than putty.exe)
- Fix XSS (easy, just check the username post string: fixed in other panels I have made)
- Add a payment gateway (AUTOBUY DECRYPTION KEY)
