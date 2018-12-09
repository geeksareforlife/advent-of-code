def getInsertPosition(circle, currentMarble):
	return getOffsetPosition(circle, currentMarble, 1, 'clockwise') + 1


def getOffsetPosition(circle, start, offset, direction = 'clockwise'):
	if (direction == 'clockwise'):
		return (start + offset) % len(circle)
	else:
		return (start - offset) % len(circle)

##### START MAIN #####
numPlayers = 478
highestMarble = 71240

scores = [0] * numPlayers
currentPlayer = 0

circle = [0]
currentMarble = 0

for i in range(1, highestMarble + 1):
	if (i % 23) == 0:
		# score
		scores[currentPlayer] = scores[currentPlayer] + i
		removePosition = getOffsetPosition(circle, currentMarble, 7, 'counter-colckwise')
		scores[currentPlayer] = scores[currentPlayer] + circle[removePosition]
		del(circle[removePosition])
		if removePosition < len(circle):
			currentMarble = removePosition
		else:
			# we removed the "last" marble
			currentMarble = 0
		currentPlayer = (currentPlayer + 1) % numPlayers
	else:
		insertPosition = getInsertPosition(circle, currentMarble)
		circle.insert(insertPosition, i)
		currentMarble = insertPosition
		currentPlayer = (currentPlayer + 1) % numPlayers


print("The high score was " + str(max(scores)))