from collections import Counter
import copy

def getSurrounding(seat):
	surrounding = 0

	# y is first!
	changes = [
	(-1, 0), # n
	(1, 0),  # s
	(0, 1),  # e
	(0, -1), # w
	(-1,1),  # ne
	(-1,-1), # nw
	(1,1),   # se
	(1,-1),  # sw
	]

	for change in changes:
		y = seat[0]
		x = seat[1]
		while True:
			y += change[0]
			x += change[1]
			# have we gone past an edge?
			if (y < 0 or y >= numRows) or (x < 0 or x >= numCols):
				# yes!
				break

			if rows[y][x] == '#':
				surrounding += 1
				break
			elif rows[y][x] == 'L':
				break


	

	return surrounding

def printState(state):
	for row in state:
		print(''.join(row))
	print("")

def countOccupied(state):
	count = 0
	for row in state:
		count += row.count('#')

	return count

with open('input') as input:
	rows = list(input)

rows = [list(x.strip()) for x in rows]

numRows = len(rows)
numCols = len(rows[0])

newState = copy.deepcopy(rows)

stable = False

rounds = 0

while stable == False:
	rounds += 1
	for y in range(0, numRows):
		for x in range(0, numCols):
			surrounding = getSurrounding((y,x))
			if rows[y][x] == 'L' and surrounding == 0:
				newState[y][x] = '#'
			elif rows[y][x] == '#' and surrounding >= 5:
				newState[y][x] = 'L'
			else:
				newState[y][x] = rows[y][x]

	#print(rounds)
	#printState(newState)
	if rows == newState:
		stable = True
	else:
		rows = copy.deepcopy(newState)

print(countOccupied(rows))


# seat = (6,0)

# print(rows[seat[0]][seat[1]])

# surrounding = getSurrounding(seat)
# print(surrounding)
# printState(rows)
