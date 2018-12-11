import re
from copy import deepcopy

def parsePoints(pointLines):
	points = []

	for pointLine in pointLines:
		match = re.search('position=\<\s*(?P<posX>-?\d*),\s*(?P<posY>-?\d*)\> velocity=<\s*(?P<velX>-?\d*),\s*(?P<velY>-?\d*)>', pointLine.strip())
		if match == None:
			print("Point not matched: " + pointLine)
		else:
			point = {
				'position': {'x': int(match['posX']), 'y': int(match['posY'])},
				'velocity': {'x': int(match['velX']), 'y': int(match['velY'])}
			}
			points.append(point)

	return points

def getBoundingBoxArea(points):
	box = getBoundingBox(points)

	return (box['bottomright'][0] - box['topleft'][0]) * (box['bottomright'][1] - box['topleft'][1])

def getBoundingBox(points):
	allX = list(map(lambda p: p['position']['x'], points))
	allY = list(map(lambda p: p['position']['y'], points))

	return {'topleft': (min(allX), min(allY)), 'bottomright': (max(allX), max(allY))}

def applyVelocities(points):
	for point in points:
		point['position']['x'] = point['position']['x'] + point['velocity']['x']
		point['position']['y'] = point['position']['y'] + point['velocity']['y']
	return points

def printMessage(points):
	boundingBox = getBoundingBox(points)
	offsetX = -1 * boundingBox['topleft'][0]
	offsetY = -1 * boundingBox['topleft'][1]

	# make our empty message box
	lines = [['.'] * (boundingBox['bottomright'][0] - boundingBox['topleft'][0] + 1) for i in range(boundingBox['topleft'][1], boundingBox['bottomright'][1] + 1)]

	# plot the points
	for point in points:
		lines[point['position']['y'] + offsetY][point['position']['x'] + offsetX] = '#'

	for line in lines:
		output = ''
		for point in line:
			output = output + point
		print(output)

##### START MAIN #####
with open('input') as input:
	points = parsePoints(list(input))


thisBoundingBox = getBoundingBoxArea(points)
lastBoundingBox = thisBoundingBox

while True:
	#print(thisBoundingBox)
	oldPoints = deepcopy(points)
	points = applyVelocities(points)
	thisBoundingBox = getBoundingBoxArea(points)
	if (thisBoundingBox > lastBoundingBox):
		# the last one was right!
		break
	else:
		lastBoundingBox = thisBoundingBox

printMessage(oldPoints)