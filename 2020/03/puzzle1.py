with open('input') as input:
	rows = list(input)

rows = [x.strip() for x in rows]

posX = 0
posY = 0

deltaX = 3
deltaY = 1

bottom = len(rows)
wraparound = len(rows[0])

encounteredTrees = 0

while posY < bottom:
	# check what is at the current position
	if rows[posY][posX] == "#":
		encounteredTrees += 1

	# move along, Y is simple
	posY = posY + deltaY

	# X requires a wraparound!
	posX = posX + deltaX
	if (posX >= wraparound):
		posX = posX % wraparound


print("Reached the bottom and encountered " + str(encounteredTrees) + " trees")