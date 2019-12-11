import sys
sys.path.append('../packages')

from intcode.intcode import Intcode

panels = {}
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

print("The robot has painted " + str(len(panels)) + " panels")