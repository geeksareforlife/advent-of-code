from string import ascii_lowercase
from string import ascii_uppercase

safeDistance = 10000

def parseCoords(coordsList):
	coords = []

	for coord in coordsList:
		x,y = coord.strip().split(', ')
		coords.append((int(x),int(y)))

	return coords

def getBoundingBox(coords):
	minX = 1000000 # a big number
	maxX = 0
	minY = 1000000 # a big number
	maxY = 0

	for (x,y) in coords:
		if x < minX:
			minX = x
		if x > maxX:
			maxX = x
		if y < minY:
			minY = y
		if y > maxY:
			maxY = y

	return [(minX, minY), (maxX, maxY)]

def getManhattanDistance(x1, y1, x2, y2):
	return abs(x2 - x1) + abs(y2 - y1)

def isEdge(test, boundingBox):
	if test[0] == boundingBox[0][0] or test[0] == boundingBox[1][0]:
		return True
	elif test[1] == boundingBox[0][1] or test[0] == boundingBox[1][1]:
		return True
	else:
		return False

# this function only useful for the test input really
def printGrid(grid):
	columns = []
	for x,column in grid.items():
		thisColumn = []
		for y,distance in column.items():
			if distance < safeDistance:
				thisColumn.append("#")
			else:
				thisColumn.append(".")
		columns.append(thisColumn)

	for i in range(len(columns[0])):
		line = ""
		for j in range(len(columns)):
			line = line + columns[j][i]
		print(line)

##### START MAIN #####
with open('input') as input:
	coords = parseCoords(list(input))

boundingBox = getBoundingBox(coords)

# premake our grid, which is a dict of dicts
grid = {key: {key: 0 for key in list(range(boundingBox[0][1], boundingBox[1][1]+1))} for key in list(range(boundingBox[0][0], boundingBox[1][0]+1))}

# populate the owning coords
for i in range(len(coords)):
	x = coords[i][0]
	y = coords[i][1]

	# now check each position in the grid for each coord
	for gridX in range(boundingBox[0][0], boundingBox[1][0]+1):
		for gridY in range(boundingBox[0][1], boundingBox[1][1]+1):
			# skip my own coord!
			if gridX == x and gridY == y:
				continue

			distance = getManhattanDistance(x, y, gridX, gridY)
			grid[gridX][gridY] += distance

regionSize = 0
for x,column in grid.items():
	for y,distance in column.items():
		if distance < safeDistance:
			regionSize += 1

print("The safe region is " + str(regionSize) + " units")
