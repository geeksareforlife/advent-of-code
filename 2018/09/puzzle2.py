from collections import deque

##### START MAIN #####
numPlayers = 478
highestMarble = 71240 * 100

scores = [0] * numPlayers
currentPlayer = 0

circle = deque([0])
currentMarble = 0

for i in range(1, highestMarble + 1):
	if (i % 23) == 0:
		# score
		scores[currentPlayer] = scores[currentPlayer] + i
		circle.rotate(7)
		scores[currentPlayer] = scores[currentPlayer] + circle.pop()
		circle.rotate(-1)
		currentPlayer = (currentPlayer + 1) % numPlayers
		continue
	else:
		circle.rotate(-1)
		circle.append(i)

		currentPlayer = (currentPlayer + 1) % numPlayers


print("The high score was " + str(max(scores)))