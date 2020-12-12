with open('input') as input:
	instructions = list(input)
instructions = [(x[0], int(x[1:])) for x in instructions]

# N,E
position = [0,0]

directions = ['N', 'E', 'S', 'W']
currentDirection = 1

changes = {
	'N': (+1, 0),
	'E': (0, +1),
	'S': (-1, 0),
	'W': (0, -1)
}

for ins in instructions:
	if ins[0] in directions:
		position[0] = position[0] + (changes[ins[0]][0] * ins[1])
		position[1] = position[1] + (changes[ins[0]][1] * ins[1])

	elif ins[0] == 'R':
		currentDirection = (currentDirection + int(ins[1] / 90)) % 4

	elif ins[0] == 'L':
		currentDirection = (currentDirection - int(ins[1] / 90)) % 4

	elif ins[0] == 'F':
		direction = directions[currentDirection]
		position[0] = position[0] + (changes[direction][0] * ins[1])
		position[1] = position[1] + (changes[direction][1] * ins[1])

	#print(str(position) + " facing " + directions[currentDirection])

manhattan = abs(position[0]) + abs(position[1])

print("The Manhattan distance is " + str(manhattan))