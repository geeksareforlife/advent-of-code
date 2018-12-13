def getRectanglePower(endX, endY, powergrid):
	power = 0
	for x in range(0, endX):
		for y in range(0, endY):
			power = power + powergrid[x][y]
	return power

def getSquarePower(startX, startY, size, rectangles):
	# The area of the square can be derived from the rectangles calculated earlier
	
	endX = startX + size
	endY = startY + size

	power = rectangles[endX][endY] - rectangles[endX][startY] - (rectangles[startX][endY] - rectangles[startX][startY])

	return power

def calculatePowerLevel(x, y, powergrid):
	# THIS IS THE PUZZLE INPUT!
	serial = 3613

	rackID = (x + 1) + 10

	power = rackID * (y + 1)
	power = power + serial
	power = power * rackID

	if power < 100:
		power = 0
	else:
		power = int(str(power)[len(str(power)) - 3])

	power = power - 5

	powergrid[x][y] = power

	return powergrid

powergrid = [[0] * 300 for i in range(300)]

maxPower = 0
squareX = 0
squareY = 0
squareSize = 0

# pre-populate powergrid
for x in range(300):
	for y in range(300):
		powergrid = calculatePowerLevel(x ,y, powergrid)

# populate cache with rectangles from 0,0 to x,y for all x,y
cache = [[0] * 300 for i in range(300)]

for x in range(300):
	print("X: " + str(x))
	for y in range(300):
		cache[x][y] = getRectanglePower(x, y, powergrid)

for size in range(1,300):
	print("Checking size " + str(size))
	for x in range(300 - size + 1):
		for y in range(300 - size + 1):
			power = getSquarePower(x, y, size, cache)
			if power > maxPower:
				maxPower = power
				# realworld coords are +1
				squareX = x + 1
				squareY = y + 1
				squareSize = size

print("The greatest power level was " + str(maxPower) + " @ " + str(squareX) + "," + str(squareY) + "," + str(squareSize))