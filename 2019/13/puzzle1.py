import sys
from termcolor import colored, cprint
sys.path.append('../packages')

from intcode.intcode import Intcode

computer = Intcode()

f = open('input')
programme = f.read();

computer.loadProgramme(programme)
computer.setOutputMode("saved")
computer.setInputMode("internal")

pixels = {}

computer.run()


while True:
	coordX = computer.getOutput()
	coordY = computer.getOutput()
	tileId = computer.getOutput()
	if coordX == None or coordY == None or tileId == None:
		if coordX != None:
			print("X coordinate not empty")
		if coordY != None:
			print("Y coordinate not empty")
		if tileId != None:
			print("Tile ID not empty")
		break

	pixels[(coordX, coordY)] = tileId

numBlocks = 0
for pixel in pixels:
	if pixels[pixel] == 2:
		numBlocks = numBlocks + 1

print("There are " + str(numBlocks) + " blocks")


# minX = min(pixels)[0]
# maxX = max(pixels)[0]
# minY = min(pixels, key = lambda t: t[1])[1]
# maxY = max(pixels, key = lambda t: t[1])[1]

# colours = [
# 	'black',
# 	'red',
# 	'blue',
# 	'white',
# 	'yellow'
# ]

# # should have flipped the Y, but it is readable!
# for y in range(minY, maxY+1):
# 	for x in range(minX, maxX+1):
# 		if (x,y) not in pixels:
# 			colour = 0
# 		else:
# 			colour = pixels[(x,y)]

# 		if colours[colour] == "black":
# 			cprint(" ", end='')
# 		else:
# 			cprint(" ", 'red', 'on_' + colours[colour], end='')

# 	cprint(" ")