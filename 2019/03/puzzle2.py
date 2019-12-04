def getWireCoords(pathString):
	coords = {}

	currentX = 0
	currentY = 0
	totalSteps = 0

	path = pathString.strip().split(",")

	for instruction in path:
		direction = instruction[0]
		distance = int(instruction[1: len(instruction)])

		for i in range(distance):
			if direction == "D" or direction == "L":
				step = -1
			else:
				step = 1

			if direction == "D" or direction == "U":
				currentY = currentY + step
			else:
				currentX = currentX + step

			totalSteps = totalSteps + 1

			if (currentX, currentY) not in coords:
				coords[(currentX, currentY)] = totalSteps

	return coords



with open('input') as input:
	wires = list(input)

# get the coords for each wire
firstWire = getWireCoords(wires[0])
secondWire = getWireCoords(wires[1])

# now find the corssing places

crossingSteps = []

for coord in secondWire:
	if coord in firstWire:
		distance = firstWire[(coord[0], coord[1])] + secondWire[(coord[0], coord[1])]
		crossingSteps.append(distance)


print("The shortest path is " + str(min(crossingSteps)))