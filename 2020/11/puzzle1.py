from collections import Counter
import copy

def getSurrounding(seat):
	y1 = max(seat[0]-1, 0)
	x1 = max(seat[1]-1, 0)
	y2 = min(seat[0]+1, numRows - 1)
	x2 = min(seat[1]+1, numCols - 1)

	surrounding = []

	if y1 != seat[0]:
		surrounding = surrounding + rows[y1][x1:x2+1]
	if y2 != seat[0]:
		surrounding = surrounding + rows[y2][x1:x2+1]
	
	if seat[1] < (numCols - 1):
		surrounding = surrounding + rows[seat[0]][x2:x2+1]
	if seat[1] > 0:
		surrounding = surrounding + rows[seat[0]][x1:x1+1]

	return Counter(surrounding)

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
			if rows[y][x] == 'L' and surrounding['#'] == 0:
				newState[y][x] = '#'
			elif rows[y][x] == '#' and surrounding['#'] >= 4:
				newState[y][x] = 'L'
			else:
				newState[y][x] = rows[y][x]

	# print(rounds)
	# printState(newState)
	if rows == newState:
		stable = True
	else:
		rows = copy.deepcopy(newState)

print(countOccupied(rows))


# seat = (1,1)

# print(rows[seat[0]][seat[1]])

# surrounding = getSurrounding(seat)
# print(surrounding['L'])
