import re
import itertools

steps = 1000
inputFile = "input"

def parseMoons(moons):
	positions = []

	for moon in moons:
		match = re.search('\<x=([-\d]*), y=([-\d]*), z=([-\d]*)>', moon)

		if match:
			position = [int(match[1]), int(match[2]), int(match[3])]
			positions.append(position)

	return positions

def updateVelocities(velocities, moonPositions, moonPair):
	moonA = moonPair[0]
	moonB = moonPair[1]

	for axis in [0,1,2]:
		if moonPositions[moonA][axis] > moonPositions[moonB][axis]:
			velocities[moonA][axis] = velocities[moonA][axis] - 1
			velocities[moonB][axis] = velocities[moonB][axis] + 1
		elif moonPositions[moonA][axis] < moonPositions[moonB][axis]:
			velocities[moonA][axis] = velocities[moonA][axis] + 1
			velocities[moonB][axis] = velocities[moonB][axis] - 1

	return velocities

def calculateEnergies(moonsDetails):
	energies = []

	for moon in moonsDetails:
		energies.append(sum([abs(i) for i in moon]))

	return energies


with open(inputFile) as input:
	moonPositions = parseMoons(list(input))

velocities = [[0,0,0],[0,0,0],[0,0,0],[0,0,0]]


for step in range(steps):
	# apply gravity
	moonPairs = itertools.combinations([0,1,2,3], 2)
	for moonPair in moonPairs:
		velocities = updateVelocities(velocities, moonPositions, moonPair)

	# apply velocities
	for i in range(len(moonPositions)):
		moonPositions[i][0] = moonPositions[i][0] + velocities[i][0]
		moonPositions[i][1] = moonPositions[i][1] + velocities[i][1]
		moonPositions[i][2] = moonPositions[i][2] + velocities[i][2]


potentialEnergies = calculateEnergies(moonPositions)
kineticEnergies = calculateEnergies(velocities)

totalEnergy = 0
for i in range(len(potentialEnergies)):
	moonEnergy = potentialEnergies[i] * kineticEnergies[i]
	totalEnergy = totalEnergy + moonEnergy

print("The total energy in the system is " + str(totalEnergy))