# All x,y coords are -1 compared to realworld

def getSquarePower(startX, startY, powergrid):
	power = 0
	#print("START")
	for x in range(startX, startX + 3):
		for y in range(startY, startY + 3):
			# always check if powerlevel is 0
			if powergrid[x][y] == 0:
				powergrid = calculatePowerLevel(x ,y, powergrid)
			power = power + powergrid[x][y]
			#print(str(x) + "," + str(y) + " : " + str(powergrid[x][y]))
	#print("END")

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
locX = 0
locY = 0

# last place you can make a 3x3 square is at coord 298,298
for x in range(298):
	for y in range(298):
		power = getSquarePower(x, y, powergrid)
		if power > maxPower:
			maxPower = power
			# realworld coords are +1
			locX = x + 1
			locY = y + 1

print("The greatest power level was " + str(maxPower) + " @ " + str(locX) + "," + str(locY))