#!/usr/bin/env python

import time
from xlib import XEvents



class KbdCounter(object):
    def __init__(self, user):
        self.dt = 60
        self.user = user
        now = time.time()
        self.nextsave = now + self.dt  
        self.thishour_count = 0
        

    def save(self):
        now = time.time()
        self.nextsave = now + self.dt    
        print "Count: ", self.thishour_count
        
        import json
        import urllib2
        
        # UPDATE THESE VARIABLES
        baseUrl = "http://compphys.dragly.org"
        # END UPDATE VARIABLES
        
        pluginUrl = baseUrl + "/wp-content/plugins/keyboard-counter/"
        registerUrl = pluginUrl + "register-presses.php?user=" + self.user + "&presses=" + str(self.thishour_count)
        
        runData = json.load(urllib2.urlopen(registerUrl))
        
        print "Returned data from server: " + str(runData)
        
        self.thishour_count = 0


    def run(self):
        events = XEvents()
        events.start()
        while not events.listening():
            # Wait for init
            time.sleep(1)

        try:
            while events.listening():
                evt = events.next_event()
                if not evt:
                    time.sleep(0.5)
                    continue
                
                if evt.type != "EV_KEY" or evt.value != 1: # Only count key down, not up.
                    continue

                self.thishour_count+=1
            
                if time.time() > self.nextsave:
                    self.save()
            
        except KeyboardInterrupt:
            events.stop_listening()
            self.save()
            
        except:
            print "Caught exception, probably not connected to the interwebs..."

            
                    

def run():
    import sys
    if len(sys.argv) < 2:
        print "Usage: " + sys.argv[0] + " username"
    else:
        user = sys.argv[1]
        kc = KbdCounter(user)
        kc.run()
        
run()    
