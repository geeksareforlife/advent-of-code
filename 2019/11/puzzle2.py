import sys
from termcolor import colored, cprint

sys.path.append('../packages')

from intcode.intcode import Intcode

panels = {(0,0): 1}
currentCoord = (0,0)
direction = "up"

possibleDirections = ['up', 'right', 'down', 'left']

def getCurrentPanelColour(coordinate):
	if coordinate in panels:
		return panels[coordinate]
	else:
		return 0;

def paintPanel(coordinate, colour):
	panels[coordinate] = colour

def turn(rotation):
	if rotation == 0:
		rotation = -1

	i = possibleDirections.index(direction)

	i = i + rotation

	if i >= len(possibleDirections):
		i = i - len(possibleDirections)
	elif i < 0:
		i = i + len(possibleDirections)

	return possibleDirections[i]

def move():
	currX = currentCoord[0]
	currY = currentCoord[1]

	if direction == "up":
		currY = currY + 1
	elif direction == "down":
		currY = currY - 1
	elif direction == "right":
		currX = currX + 1
	elif direction == "left":
		currX = currX - 1

	return (currX, currY)

computer = Intcode()

f = open('input')
programme = f.read();

computer.loadProgramme(programme)
computer.setOutputMode("saved")
computer.setInputMode("internal")

computer.run()

while computer.hasHalted() == False:
	currentColour = getCurrentPanelColour(currentCoord)

	computer.addInput(currentColour)


	paintPanel(currentCoord, computer.getOutput())
	direction = turn(computer.getOutput())

	currentCoord = move()

minX = min(panels)[0]
maxX = max(panels)[0]
minY = min(panels, key = lambda t: t[1])[1]
maxY = max(panels, key = lambda t: t[1])[1]

# should have flipped the Y, but it is readable!
for y in range(minY, maxY+1):
	for x in range(minX, maxX+1):
		if (x,y) not in panels or panels[(x,y)] == 0:
			cprint(" ", end='')
		elif panels[(x,y)] == 1:
			cprint(" ", 'red', 'on_white', end='')

	cprint(" ")