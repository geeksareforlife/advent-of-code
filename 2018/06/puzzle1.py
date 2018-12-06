
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

##### START MAIN #####
with open('input.test1') as input:
	coords = parseCoords(list(input))

boundingBox = getBoundingBox(coords)



print(boundingBox)