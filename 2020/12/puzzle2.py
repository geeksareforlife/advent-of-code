def rotateWaypoint(waypoint, times, direction):
	eastMultiplier = {
		'R': 1,
		'L': -1
	}

	northMultiplier = {
		'R': -1,
		'L': 1
	}
	for i in range(times):
		newE = waypoint[0] * eastMultiplier[direction]
		newN = waypoint[1] * northMultiplier[direction]

		waypoint = [newN, newE]

	return waypoint

with open('input') as input:
	instructions = list(input)
instructions = [(x[0], int(x[1:])) for x in instructions]

# N,E
position = [0,0]
waypoint = [1,10]

changes = {
	'N': (+1, 0),
	'E': (0, +1),
	'S': (-1, 0),
	'W': (0, -1)
}

for ins in instructions:
	if ins[0] in list(changes):
		waypoint[0] = waypoint[0] + (changes[ins[0]][0] * ins[1])
		waypoint[1] = waypoint[1] + (changes[ins[0]][1] * ins[1])

	elif ins[0] in ['L', 'R']:
		waypoint = rotateWaypoint(waypoint, int(ins[1] / 90), ins[0])

	elif ins[0] == 'F':
		position[0] = position[0] + (waypoint[0] * ins[1])
		position[1] = position[1] + (waypoint[1] * ins[1])

	#print(str(position) + " with the waypoint at " + str(waypoint))

manhattan = abs(position[0]) + abs(position[1])

print("The Manhattan distance is " + str(manhattan))