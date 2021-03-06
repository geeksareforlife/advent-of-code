from string import ascii_lowercase
from string import ascii_uppercase


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
		for y,details in column.items():
			if details['owner'] == 'tied':
				thisColumn.append(".")
			elif details['distance'] == 0:
				thisColumn.append(ascii_uppercase[details['owner']])
			else:
				thisColumn.append(ascii_lowercase[details['owner']])
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
grid = {key: {key: {} for key in list(range(boundingBox[0][1], boundingBox[1][1]+1))} for key in list(range(boundingBox[0][0], boundingBox[1][0]+1))}

# populate the owning coords
for i in range(len(coords)):
	x = coords[i][0]
	y = coords[i][1]
	# take over that grid position, no matter what!
	grid[x][y]['owner'] = i
	grid[x][y]['distance'] = 0

	# now check each position in the grid for each coord
	for gridX in range(boundingBox[0][0], boundingBox[1][0]+1):
		for gridY in range(boundingBox[0][1], boundingBox[1][1]+1):
			# skip my own coord!
			if gridX == x and gridY == y:
				continue

			distance = getManhattanDistance(x, y, gridX, gridY)
			if 'owner' not in grid[gridX][gridY]:
				# nobody has it yet, it is mine!
				# this will only happen for the first coord, of course
				grid[gridX][gridY]['owner'] = i
				grid[gridX][gridY]['distance'] = distance
			else:
				# not tied, are we closer than the current owner?
				if grid[gridX][gridY]['distance'] > distance:
					# yes! it is ours
					grid[gridX][gridY]['owner'] = i
					grid[gridX][gridY]['distance'] = distance
				elif grid[gridX][gridY]['distance'] == distance:
					# lost for now!
					grid[gridX][gridY]['owner'] = 'tied'
					grid[gridX][gridY]['distance'] = distance

# now we have populated the grid, we need to add up how many points each coord owns
# if their area touches the edge of the bounding box then it is infinite
# we will store this as -1
ownedCount = [0] * len(coords)

for x,column in grid.items():
	for y,details in column.items():
		if details['owner'] == 'tied':
			continue
		if isEdge((x,y),boundingBox):
			ownedCount[int(details['owner'])] = -1
		else:
			if ownedCount[int(details['owner'])] == -1:
				# this owner is already tied
				continue
			else:
				ownedCount[int(details['owner'])] += 1


print("The largest area is " + str(max(ownedCount)))