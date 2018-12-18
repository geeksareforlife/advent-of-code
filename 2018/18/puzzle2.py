from copy import deepcopy
import os
import time

def parseField(lines):
	maxX = len(lines[0].strip())
	maxY = len(lines)

	field = [['.'] * maxY for i in range(maxX)]

	for y in range(maxY):
		for x in range(maxX):
			field[x][y] = lines[y][x]

	return field

def clearScreen():
	if os.name == 'nt':
		_ = os.system('cls')
	else:
		_ = os.system('clear')

def printField(minute, field):
	maxX = len(field)
	maxY = len(field[0])

	clearScreen()
	print("Minute: " + str(minute))

	for y in range(maxY):
		line = ""
		for x in range(maxX):
			line = line + field[x][y]
		print(line)

def getAdjacentAcres(x, y, field):
	maxX = len(field)
	maxY = len(field[0])

	adjacent = [(0, -1), (0, 1), (-1, 0), (1, 0), (-1, -1), (-1, 1), (1, -1), (1, 1)];

	acres = {
		'open': 0,
		'trees': 0,
		'lumberyard': 0
	}

	for offset in adjacent:
		thisX = x + offset[0]
		thisY = y + offset[1]

		# check within bounds:
		if thisX < 0 or thisX >= maxX or thisY < 0 or thisY >= maxY:
			continue

		if field[thisX][thisY] == '.':
			acres['open'] = acres['open'] + 1
		elif field[thisX][thisY] == '|':
			acres['trees'] = acres['trees'] + 1
		elif field[thisX][thisY] == '#':
			acres['lumberyard'] = acres['lumberyard'] + 1

	return acres


def runMinute(field):
	maxX = len(field)
	maxY = len(field[0])

	newField = [['.'] * maxY for i in range(maxX)]

	for y in range(maxY):
		for x in range(maxX):
			acres = getAdjacentAcres(x, y, field)
			if field[x][y] == '.':
				if acres['trees'] >= 3:
					newField[x][y] = '|'
				else:
					newField[x][y] = '.'
			elif field[x][y] == '|':
				if acres['lumberyard'] >= 3:
					newField[x][y] = '#'
				else:
					newField[x][y] = '|'
			elif field[x][y] == '#':
				if acres['lumberyard'] >= 1 and acres['trees'] >= 1:
					newField[x][y] = '#'
				else:
					newField[x][y] = '.'

	return newField

##### START MAIN #####
with open('input') as input:
	field = parseField(list(input))

# from observation, enters a cycle at 400 that lasts until 427 (28 fields)
minutes = 428

fields = []

# get the 30 fields in the cycle
for i in range(minutes):
	oldField = deepcopy(field)

	field = runMinute(oldField)

	if i >= 400:
		fields.append(deepcopy(field))

# now work out what field we will end up on.
finalMinute = 1000000000
fieldIndex = ((finalMinute - (minutes-1)) % 28) - 1

print(len(fields))
print(fieldIndex)

field = fields[fieldIndex]


acres = {
	'open': 0,
	'trees': 0,
	'lumberyard': 0
}

maxX = len(field)
maxY = len(field[0])

for y in range(maxY):
	for x in range(maxX):
		if field[x][y] == '.':
			acres['open'] = acres['open'] + 1
		elif field[x][y] == '|':
			acres['trees'] = acres['trees'] + 1
		elif field[x][y] == '#':
			acres['lumberyard'] = acres['lumberyard'] + 1

resources = acres['lumberyard'] * acres['trees']

print("There are " + str(resources) + " resources left")