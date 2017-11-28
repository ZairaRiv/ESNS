Settings.MoveMouseDelay = 0
Settings.ObserveScanRate = 0.1
locationOptions = ('Vineyard Elementary', 'Fresno Montessori School', 'Tioga Middle School', 'CSU Fresno', 'University High School', 'None of the Above')
location = select("Select the location:", options = locationOptions)
eventOptions = ('Shooting', 'Domestic Abuse', 'Flood', 'Gas Leak', 'Fighting', 'Rape', 'Stalking', 'Water Leak', 'None of the Above')
eventSel = select("Select the event:", options = eventOptions)
occuring = input("Type where the event occurs:")
userLoc = input("Type where the user is located:")
running = True
def runHotkey(event):
    global running
    running = False
Env.addHotkey(Key.SHIFT, KeyModifier.SHIFT, runHotkey)
type(Pattern("1511901788055.png").similar(0.45), "esns"+Key.ENTER)
wait(Pattern("1511899150060.png").similar(0.80))
click(Pattern("1511899150060.png").similar(0.80).targetOffset(-10,70))
wait("1511899285585.png")
click(Pattern("1511899285585.png").targetOffset(-5,51))
wait("1511899335233.png")
if(location == 'Vineyard Elementary'):
    click(Pattern("1511899335233.png").targetOffset(-3,-66))
elif(location == 'Fresno Montessori School'):
    click(Pattern("1511899335233.png").targetOffset(-7,-25))
elif(location == 'Tioga Middle School'):
    click(Pattern("1511899335233.png").targetOffset(-3,21))
elif(location == 'CSU Fresno'):
    click(Pattern("1511899335233.png").targetOffset(-3,65))
elif(location == 'University High School'):
    click(Pattern("1511899335233.png").targetOffset(-7,110))
elif(location == 'None of the Above'):
    click(Pattern("1511899335233.png").targetOffset(0,149))
wait("1511899553563.png")
if(eventSel == 'Shooting'):
    click(Pattern("1511899553563.png").targetOffset(0,-124))
elif(eventSel == 'Domestic Abuse'):
    click(Pattern("1511899553563.png").targetOffset(-11,-80))
elif(eventSel == 'Flood'):
    click(Pattern("1511899553563.png").targetOffset(-1,-41))
elif(eventSel == 'Gas Leak'):
    click(Pattern("1511899553563.png").targetOffset(-5,-1))
elif(eventSel == 'Fighting'):
    click(Pattern("1511899553563.png").targetOffset(-1,43))
elif(eventSel == 'Rape'):
    click(Pattern("1511899553563.png").targetOffset(-3,88))
elif(eventSel == 'Stalking'):
    click(Pattern("1511899553563.png").targetOffset(-1,130))
elif(eventSel == 'Water Leak'):
    click(Pattern("1511899553563.png").targetOffset(-9,170))
elif(eventSel == 'None of the Above'):
    click(Pattern("1511899553563.png").targetOffset(-7,213))
while running:
    wait("1511899625958.png")
    type(Pattern("1511899625958.png").targetOffset(-40,34), occuring)
    click(Pattern("1511899625958.png").targetOffset(-12,71))
    wait("1511907282584.png")
    type(Pattern("1511907282584.png").targetOffset(-14,32), userLoc)
    click(Pattern("1511907282584.png").targetOffset(-4,68))
    wait("1511908583590.png")
    click("1511908583590.png")