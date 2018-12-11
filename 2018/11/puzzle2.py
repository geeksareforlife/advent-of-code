# All x,y coords are -1 compared to realworld

squareCache = {}

def getSquarePower(startX, startY, size, powergrid):
	index = str(startX) + "," + str(startY)
	if size > 1:
		power = squareCache[size-1][index]
	else:
		power = 0

	# add on the 1x1's around the outside
	# first, the far right column (minus the bottom)
	x = startX + size - 1
	for y in range(startY, startY + size - 1):
		power = power + powergrid[x][y]
	# next, the bottom row
	y = startY + size - 1
	for x in range(startX, startX + size):
		power = power + powergrid[x][y]
	 
	# for x in range(startX + size - 1, startX + size):
	# 	# on the lastx, we need all the 1x1s
	# 	if x == 
	# 	for y in range(startY + size - 1, startY + size):
	#  		power = power + powergrid[x][y]

	if size not in squareCache:
		squareCache[size] = {}
	squareCache[size][index] = power

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

# last place you can make a 3x3 square is at coord 298,298
for size in range(1,300):
	#print("Checking size " + str(size))
	for x in range(300 - size + 1):
		for y in range(300 - size + 1):
			power = getSquarePower(x, y, size, powergrid)
			if power > maxPower:
				maxPower = power
				# realworld coords are +1
				squareX = x + 1
				squareY = y + 1
				squareSize = size

print("The greatest power level was " + str(maxPower) + " @ " + str(squareX) + "," + str(squareY) + "," + str(squareSize))