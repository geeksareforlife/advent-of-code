import numpy

def checkSlope(mapRows, deltaX, deltaY):
	posX = 0
	posY = 0

	bottom = len(mapRows)
	wraparound = len(mapRows[0])

	encounteredTrees = 0

	while posY < bottom:
		# check what is at the current position
		if mapRows[posY][posX] == "#":
			encounteredTrees += 1

		# move along, Y is simple
		posY = posY + deltaY

		# X requires a wraparound!
		posX = posX + deltaX
		if (posX >= wraparound):
			posX = posX % wraparound

	return encounteredTrees


with open('input') as input:
	mapRows = list(input)

mapRows = [x.strip() for x in mapRows]

slopes = [(1,1), (3,1), (5,1), (7,1), (1,2)];

trees = []

for slope in slopes:
	encounteredTrees = checkSlope(mapRows, slope[0], slope[1]);
	trees.append(encounteredTrees)

print("The result is " + str(numpy.prod(trees)))