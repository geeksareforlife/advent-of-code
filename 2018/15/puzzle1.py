import os
import astar

import time

def clearScreen():
	if os.name == 'nt':
		_ = os.system('cls')
	else:
		_ = os.system('clear')

def parseField(lines):
	players = []

	maxX = len(lines[0].strip())
	maxY = len(lines)

	field = [[""] * maxY for i in range(maxX)]

	for y in range(len(lines)):
		line = lines[y].strip()
		for x in range(len(line)):
			field[x][y] = line[x]
			if line[x] == "G" or line[x] == "E":
				players.append({
					'x': x,
					'y': y,
					'power': 3,
					'hp': 200,
					'alive': True,
					'type': line[x]
				})

	return field, players

def getMaxCoords(field):
	maxX = len(field)
	maxY = len(field[0])

	return maxX, maxY

def printField(field, rounds, players):
	# TODO: add player HP
	maxX, maxY = getMaxCoords(field)

	clearScreen()
	print("Round: " + str(rounds))
	print("")
	for y in range(maxY):
		line = ""
		for x in range(maxX):
			line = line + field[x][y]
		print(line)

def getTargets(field, playerIndex, players):
	adjacentSquares = ((0, -1), (-1, 0), (1, 0), (0, 1),)

	playerType = players[playerIndex]['type']
	targets = []

	maxX, maxY = getMaxCoords(field)

	for potentialTarget in players:
		if potentialTarget['type'] != playerType:
			for newPosition in adjacentSquares: # Adjacent squares
				targetX = potentialTarget['x'] + newPosition[0]
				targetY = potentialTarget['y'] + newPosition[1]

				# Make sure within range
				if targetX >= maxX or targetX < 0 or targetY >= maxY or targetY < 0:
					continue

				# Make sure walkable terrain
				if field[targetX][targetY] != '.':
					continue
				
				targets.append((targetX, targetY))

	return targets

def getTarget(field, playerIndex, players):
	targets = getTargets(field, playerIndex, players)
	if (playerIndex == 5):
		print("Targets")
		print(targets)
	pathLength = 10000000
	path = []
	finalTarget = None

	for target in targets:
		found, currentPath = astar.astar(field, (players[playerIndex]['x'], players[playerIndex]['y']), (target[0], target[1]))
		if found == True and len(currentPath) < pathLength:
			pathLength = len(currentPath)
			path = currentPath
			finalTarget = target

	return finalTarget, path

def movePlayer(field, playerIndex, players, newPosition):
	oldX = players[playerIndex]['x']
	oldY = players[playerIndex]['y']

	playerType = players[playerIndex]['type']

	field[oldX][oldY] = '.'
	field[newPosition[0]][newPosition[1]] = playerType

	players[playerIndex]['x'] = newPosition[0]
	players[playerIndex]['y'] = newPosition[1]

	return field, players

def runGame(field, players):
	rounds = 0
	while True:
		for playerIndex in range(len(players)):
			target, path = getTarget(field, playerIndex, players)
			if target != None:
				# the first step in the returned path is the starting square
				field, players = movePlayer(field, playerIndex, players, path[1])
				print(players[playerIndex])
				print(target)
				print(path)
		rounds = rounds + 1
		#printField(field, rounds, players)
		return rounds


##### START MAIN #####
with open('input.test1') as input:
	field, players = parseField(list(input))

# for i in range(10):
# 	printField(field, i, players)
# 	time.sleep(1)


rounds = runGame(field, players)