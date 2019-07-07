
# GoldRAAS <img src="https://hotemoji.com/images/dl/2/lock-emoji-by-twitter.png" width="40" height="40">
> Ransomware with a web panel
## SETUP
In the client change the user ID to whoever it is.
<u>I will make a stub generator when I next update it!</u>
## NOTES
1. This was going to be the source for a "Ransomware As A Service" which I got bored of developing. I am sure someone who see's this can salvage it.
1. The client doesn't look amazing.
1. This was made for fun, I am not fond of github so tell me if I publishd this wrong.
1. The client was made in C#. (so it's not native)
1. The client was made in Visual Studio 2017.
1. A lot of the functions are *ahem* stolen from stackoverflow and some other sites (don't have links, may be in comments on code)
1. There is no SQL Injection exploits, challenge you to find one.
1. There is XSS however I am fully aware of this and know how to fix it.
1. The decryption key is generated server side and then given to the client via a GET request. If the client makes the GET request again the server will tell them to piss off basically.
1. The decryption key is deleted from the users memeory as soon as the client has encrypted the file(/s) to be safe.
1. The encryption is done with AES256 and a random salt to prevent precracking. (EXTREMELY UNLIKELY)
## To Do
- Generate Stub
- Encrypt whole system (rather than putty.exe)
- Fix XSS (easy, just check the username post string: fixed in other panels I have made)
- Add a payment gateway (AUTOBUY DECRYPTION KEY)
