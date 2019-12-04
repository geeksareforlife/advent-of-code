def getWireCoords(pathString):
	coords = []

	currentX = 0
	currentY = 0

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

			coords.append((currentX, currentY))

	return coords



with open('input') as input:
	wires = list(input)

# get the coords for each wire
firstWire = getWireCoords(wires[0])
secondWire = getWireCoords(wires[1])

# now find the corssing places

firstWire = set(firstWire)

crossingDistances = []

for coord in secondWire:
	if coord in firstWire:
		distance = abs(coord[0]) + abs(coord[1])
		crossingDistances.append(distance)


print("The shortest path is " + str(min(crossingDistances)))