<?php
	define("R10ENTER", "You press the green button. It makes a clicking sound and stays pressed. You jump as the trap door, and all four doors, slam shut. The torches extinguish and for a moment you think that you made a mistake.<BR /><BR />This thought is further enforced by the fact that the floor beneath you begins to open and you plummet down a metal shaft. The shaft angles like the base of a slide and you slide out into a brightly lit room. The passage to the shaft is quickly closed off by a large metal door.");
	define("R10INFO", "The bright white lights, white paint, and white tile floors are almost blinding. Your eyes take a minute or two to adjust. You see a metal cart in the corner of the room. A single laptop sits upon the metal cart and it appears as though someone has already logged in. It looks to be a terminal of some sorts. You see a prompt that reads 'lagent@bsjtf [~]# ' and a cursor that is blinking slowly.");
	define("R10LOOK", "This is a very interesting room. I mean, just look at the great use of a single color! I just love it. The institutional look is so in this year. But, I digress. There is a metal cart upon which a laptop sits. It looks like someone has logged into it already.");
	define("CARTLOOK", "It's a plain metal cart. Nothing too interesting about it; except maybe that laptop.");
	define("LAPTOPLOOK", "It's a laptop that has been logged in already.");
	define("FLAG3", "flag=UPUPDOWNDOWNLEFTRIGHTLEFTRIGHTABSELECTSTART");
	define("LAPTOPCNF", "command not found");
	define("LAPTOPUSE", "You step up to the laptop. It simply has a bash prompt and is waiting for your command. Type QUIT to stop using the laptop.");
	define("LAPTOPQUIT", "You step away from the laptop.");
	define("BASHPROMPT", "lagent@bsjtf [~]# ");
	define("LS", "drwxr-xr-x 2 lagent lagent 4096 Jun 25 20:45 ./<BR />drwx------ 3 bsjtf  bsjtf  4096 Jun 25 20:45 ../<BR />-rwxr-xr-x 3 lagent lagent  871 Jun 25 20:45 knockknock.py");
	define("PWD", "/home/lagent");
	define("ACCESSDENIED", "access denied");
	define("MIYS", "What? Make it yourself.");
	define("SANDWICH", "Okay.");
	define("WHOAMI", "lagent");
	define("NOTTHATEASY", "Ohai there! You thought it'd be that easy? You. Are. So. Cute!! Mmm. I could just gobble you up. Nom nom nom. So. Yeah. Try Harder and all!");
	define("PYTHON", "You enter the command 'python' on the laptop. Just then a panel opens on one of the walls out of which come four deadly pythons. They knock you down and begin to devour you alive....<BR /><BR />*Wait* You just swore out loud didn't you?!<BR /><BR />What you don't like typing '> TURN ON FLASHLIGHT'?! HAHAHAHA<BR /><BR />I'm just kidding! Try Harder! ");
	define("HISTORY", "    1  sudo vi knockknock.py<BR />    2  python knockknock.py<BR />    3  nc 10.2.1.3 4444<BR />    4  sudo vi knockknock.py<BR /><BR />Those were the previous commands before you starting messing around.<BR />This is what I've understood as your last commands entered:<BR /><BR />    5  keyboard doopdy doop<BR />    6  in the computer!<BR />    7  duhhhhhhhhhhhhhhhhhhhhh<BR />    8  i hate ben0xa!");
	define("CATKNOCK", "#!/usr/bin/python<BR /><BR />from sys import exit<BR />from operator import xor<BR />import time<BR /><BR />now = time.strftime(&#39;%m%d%Y%H%M%S&#39;)<BR /><BR />def getaccess(mask, ditdah, salt):<BR />  fn = []<BR />  tn = []<BR />  ditdah = ditdah.replace(&quot; &quot;, &quot;&quot;)<BR />  idx = -1<BR />  ddidx = -1<BR />  tidx = -1<BR />  if(now[-2:] == &quot;00&quot; or now[-2:] == &quot;30&quot;):<BR />    nstr = str(now) + str(salt)<BR />  else:<BR />    nstr = str(salt)<BR /><BR />  for ltr in mask:<BR />    idx += 1<BR />    ddidx += 1<BR />    tidx +=1<BR />    if(ddidx >= len(ditdah)):<BR />      ddidx = 0<BR />    if(tidx >= len(nstr)):<BR />      tidx = 0<BR /><BR />    fn.append(chr(xor(xor(ord(ltr), ord(ditdah[ddidx:ddidx+1])), ord(nstr[tidx:tidx+1]))))<BR /><BR />  fnstr = &quot;&quot;.join(map(str, fn))<BR />  return fnstr<BR />  <BR />def main():<BR />  firsthacker = &quot;&quot;<BR />  rats = &quot;&quot;<BR />  year = &quot;&quot;<BR />  print getaccess(firsthacker, rats, year)<BR />  <BR />if __name__ == &quot;__main__&quot;:<BR />  main()<BR />");
	define("DOOPDYDOOP", "So, I insult your intelligence and you actually type the command? I. I don't even know what to say anymore. You win. Congratulations. You win the internet. You haven't won this game, but the internet... yeah it's yours!");
	define("INTHECOMPUTER", "Orange Mocha Frappuccino!");
	define("DUHHH", "A neutrino (/nu&#x2D0;&#x2C8;tri&#x2D0;no&#x28A;/or/nju&#x2D0;&#x2C8;tri&#x2D0;no&#x28A;/) is an electrically neutral, weakly interacting elementary subatomic particle with half-integer spin.");
	define("BEN0XA", "It's not his fault. He's not the one typing all of those silly commands and getting eaten by GRUE's now is he?");
	define("ENTERPASSCODE", "Enter passcode:");
	define("NCFAIL", "Connection terminated.<BR /><BR />You try to connect to the remote machine again after you were disconnected, but just as you are about to press enter, the power to the laptop dies. You stare blankly at the empty screen. 'Could this be it' you ask yourself. Your mind begins to race with questions. 'Did I enter the passcode correctly?' 'Is there more or is this only one of other endings?'<BR /><BR />In another room, a man sits watching you on a monitor. He can't help but laugh uncontrollably at your misfortune. He puts his cigar down to type a command on the keyboard. He simply types 'shutdown -Fr now'. As he presses enter you lose all of your ability to think, see, or exist. You are but a toy in this man's game. Surely there could have been a way to beat him at his own game. I guess you will never know.<BR /><BR />GAME OVER! Feel free to <B>RESTART<B>");
?>